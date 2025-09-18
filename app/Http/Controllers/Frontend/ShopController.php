<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function shopIndex(Request $request)
    {
        // 1. Fetch all categories
        $categories = Category::all();

        // 2. Fetch general attributes (attributes that are not associated with any specific category)
        $generalAttributes = Attribute::whereDoesntHave('categories')->get();


        // 3. Start with a base query for products
        $query = Product::query();

        // 4. Filter by Category (if a category is selected)
        if ($request->filled('category_id')) {
            $categoryId = $request->category_id;
            $query->where('category_id', $categoryId);
        }

        // 5. Apply other filters (price, attributes, etc.)
        // (You can add your filtering logic here based on the request parameters)

        // 6. Paginate the products
        $products = $query->paginate(12);

        // 7. Return the view with the data
        return view('frontend.shop', [
            'categories' => $categories,
            'generalAttributes' => $generalAttributes,
            'products' => $products,
            'selectedCategoryId' => $request->category_id,
        ]);
    }

    // Method to fetch category-specific attributes via AJAX
    public function getCategoryAttributes(Request $request)
    {
        $categoryId = $request->input('category_id');
        $category = Category::findOrFail($categoryId);
        $attributes = $category->attributes; // Use the relationship to get attributes

        return response()->json($attributes);
    }
}