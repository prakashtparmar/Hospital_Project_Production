<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabTestCategory;
use Illuminate\Http\Request;

class LabTestCategoryController extends Controller
{
    public function index()
    {
        $categories = LabTestCategory::paginate(15);
        return view('admin.lab.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.lab.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:lab_test_categories']);
        LabTestCategory::create($request->all());
        return redirect()->route('lab-test-categories.index')->with('success','Category added.');
    }

    public function edit(LabTestCategory $lab_test_category)
    {
        return view('admin.lab.categories.edit', compact('lab_test_category'));
    }

    public function update(Request $request, LabTestCategory $lab_test_category)
    {
        $lab_test_category->update($request->all());
        return redirect()->route('lab-test-categories.index')->with('success','Updated.');
    }

    public function destroy(LabTestCategory $lab_test_category)
    {
        $lab_test_category->delete();
        return back()->with('success','Deleted.');
    }
}
