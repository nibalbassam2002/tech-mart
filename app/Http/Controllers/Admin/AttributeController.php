<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index()
    {
        $attributes = Attribute::latest()->get();
        return view('admin.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
        public function create()
    {
        // Fetch main categories to display them in the create form
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.attributes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:attributes']);
        Attribute::create($request->only('name'));
        return redirect()->route('admin.attributes.index')->with('success', 'Attribute created!');
    }

    

    /**
     * Display the specified resource.
     */
    public function show(Attribute $attribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
        public function edit(Attribute $attribute)
    {
        // Fetch ONLY main categories to assign attributes to.
        $categories = Category::whereNull('parent_id')->get(); 
        
        return view('admin.attributes.edit', compact('attribute', 'categories'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $request->validate(['name' => 'required|string|max:255|unique:attributes,name,' . $attribute->id]);
        
        $attribute->update($request->only('name'));
        
        // Sync the categories relationship
        $attribute->categories()->sync($request->categories ?? []);

        return redirect()->route('admin.attributes.index')->with('success', 'Attribute updated successfully!');
    }

public function destroy(Attribute $attribute)
{
    $attribute->delete();
    return back()->with('success', 'Attribute deleted!');
}


    
}
