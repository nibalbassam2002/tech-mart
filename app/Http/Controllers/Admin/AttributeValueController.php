<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function index(Attribute $attribute)
    {
        $values = $attribute->values()->latest()->get();
        return view('admin.values.index', compact('attribute', 'values'));
    }

        public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:attributes',
            'categories' => 'nullable|array' // Validate that categories is an array if present
        ]);

        // Create the attribute first
        $attribute = Attribute::create($request->only('name'));
        
        // Then, attach the selected categories
        if ($request->has('categories')) {
            $attribute->categories()->attach($request->categories);
        }

        return redirect()->route('admin.attributes.index')->with('success', 'Attribute created successfully!');
    }

    public function destroy(Attribute $attribute, AttributeValue $value)
{
    $value->delete();
    return back()->with('success', 'Value deleted successfully!');
}
}