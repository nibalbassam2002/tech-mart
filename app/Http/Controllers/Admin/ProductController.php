<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\ProductImage;
use Illuminate\Http\Request;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    
    $products = Product::with('category')->latest()->get();

    return view('admin.products.index', compact('products'));
}

    /**
     * Show the form for creating a new resource.
     */
        public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.products.create', compact('categories'));
    }


public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255|unique:products',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'description' => 'nullable|string',
        'images' => 'nullable|array',
        'images.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        'attributes' => 'nullable|array',
        'currency' => 'required|string|max:3',
    ]);

    try {
        DB::transaction(function () use ($request, $validatedData) {
            // Create the Product
            $product = Product::create([
                'name' => $validatedData['name'],
                'slug' => Str::slug($validatedData['name']),
                'category_id' => $validatedData['category_id'],
                'price' => $validatedData['price'],
                'quantity' => $validatedData['quantity'],
                'description' => $validatedData['description'],
                'currency' => $validatedData['currency'],
            ]);

            // Handle multiple image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $imageFile) {
                    $path = $imageFile->store('products', 'public');
                    $product->images()->create(['path' => $path]);
                }
            }

            // Attach attributes
            if (!empty($validatedData['attributes'])) {
                $syncData = [];
                foreach ($validatedData['attributes'] as $attributeValues) {
                    if (is_array($attributeValues)) {
                        $syncData = array_merge($syncData, $attributeValues);
                    }
                }
                if (!empty($syncData)) {
                    $product->attributeValues()->sync($syncData);
                }
            }
        });
    } catch (\Exception $e) {
        return back()->with('error', 'Operation failed: ' . $e->getMessage())->withInput();
    }

    return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
}
    /**
     * Display the specified resource.
     */
    public function show(Product $product)
{
    // Eager load all necessary relationships for display
    $product->load('category.parent', 'images', 'attributeValues.attribute');

    return view('admin.products.show', compact('product'));
}

    /**
     * Show the form for editing the specified resource.
     */
public function edit(Product $product)
{
    $product->load('images', 'attributeValues.attribute');
    $mainCategories = Category::whereNull('parent_id')->get(); // الاسم هنا: mainCategories
    $subCategory = $product->category;
    $mainCategory = $subCategory ? $subCategory->parent : null;

    return view('admin.products.edit', compact(
        'product', 
        'mainCategories', // تمريره هنا بنفس الاسم
        'subCategory', 
        'mainCategory'
    ));
}
public function update(Request $request, Product $product)
{
    // 1. Validation
    $validatedData = $request->validate([
        'name' => 'required|string|max:255|unique:products,name,' . $product->id,
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'description' => 'nullable|string',
        'images' => 'nullable|array',
        'images.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        'attributes' => 'nullable|array',
        'currency' => 'required|string|max:3',
    ]);

    try {
        DB::transaction(function () use ($request, $validatedData, $product) {
            // 2. Update the Product's main details
            $product->update([
                'name' => $validatedData['name'],
                'slug' => Str::slug($validatedData['name']),
                'category_id' => $validatedData['category_id'],
                'price' => $validatedData['price'],
                'quantity' => $validatedData['quantity'],
                'description' => $validatedData['description'],
                'currency' => $validatedData['currency'],
            ]);

            // 3. Handle new image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $imageFile) {
                    $path = $imageFile->store('products', 'public');
                    $product->images()->create(['path' => $path]);
                }
            }

            // 4. Sync attributes (this will add/remove/update as needed)
            $syncData = [];
            if (isset($validatedData['attributes'])) {
                foreach ($validatedData['attributes'] as $attributeValues) {
                    if (is_array($attributeValues)) {
                        $syncData = array_merge($syncData, $attributeValues);
                    }
                }
            }
            $product->attributeValues()->sync($syncData);

        });
    } catch (\Exception $e) {
        return back()->with('error', 'Operation failed: ' . $e->getMessage())->withInput();
    }

    return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
}

public function destroy(Product $product)
{
    // Delete the image from storage
    if ($product->image) {
        Storage::disk('public')->delete($product->image);
    }

    $product->delete();

    return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
}
public function getSubcategories($categoryId)
{
    // We add orderBy to ensure the list is alphabetically sorted
    $subcategories = Category::where('parent_id', $categoryId)->orderBy('name', 'asc')->get();
    return response()->json($subcategories);
}
public function getAttributes($subCategoryId)
{
    // Find the sub-category first
    $subcategory = Category::find($subCategoryId);

    // Check if the sub-category exists and has a parent
    if (!$subcategory || !$subcategory->parent) {
        return response()->json([]); // Return empty if no parent
    }

    // Get the parent category
    $parentCategory = $subcategory->parent;

    // Load the attributes associated with the PARENT category, along with their values
    $attributes = $parentCategory->attributes()->with('values')->get();

    return response()->json($attributes);
}
public function destroyImage(ProductImage $image)
{
    // Delete the image file from storage
    Storage::disk('public')->delete($image->path);
    
    // Delete the record from the database
    $image->delete();
    
    // Return a success response for AJAX
    return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
}
}
