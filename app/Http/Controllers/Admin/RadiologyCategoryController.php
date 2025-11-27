<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RadiologyCategory;
use Illuminate\Http\Request;

class RadiologyCategoryController extends Controller
{
    public function index()
    {
        $categories = RadiologyCategory::paginate(15);
        return view('admin.radiology.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.radiology.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:radiology_categories']);
        RadiologyCategory::create($request->all());
        return redirect()->route('radiology-categories.index')->with('success','Category added.');
    }

    public function edit(RadiologyCategory $radiology_category)
    {
        return view('admin.radiology.categories.edit', compact('radiology_category'));
    }

    public function update(Request $request, RadiologyCategory $radiology_category)
    {
        $radiology_category->update($request->all());
        return redirect()->route('radiology-categories.index')->with('success','Updated.');
    }

    public function destroy(RadiologyCategory $radiology_category)
    {
        $radiology_category->delete();
        return back()->with('success','Deleted.');
    }
}
