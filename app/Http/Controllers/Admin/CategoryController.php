<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // Displays ONLY parent categories
        public function index()
    {
        $categories = Category::whereNull('parent_id')->withCount('children')->oldest()->get();
        return view('admin.categories.index', compact('categories'));
    }


    // Displays ONLY sub-categories of a specific parent
        public function showSubcategories(Category $category)
    {
        $subcategories = $category->children()->oldest()->get();
        return view('admin.categories.subcategories', compact('category', 'subcategories'));
    }
    public function create()
    {
        
        $parentCategories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

        public function edit(Category $category)
    {
        
        $parentCategories = Category::whereNull('parent_id')->where('id', '!=', $category->id)->get();
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'parent_id' => 'nullable|exists:categories,id'
        ]);
        
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
        ]);

        // Redirect back to the correct page
        if ($category->parent_id) {
            return redirect()->route('admin.categories.subcategories', $category->parent_id)->with('success', 'Sub-category updated!');
        }
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted successfully!');
    }
}