<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicineCategory;
use Illuminate\Http\Request;

class MedicineCategoryController extends Controller
{
    public function index()
    {
        $categories = MedicineCategory::paginate(15);
        return view('admin.pharmacy.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.pharmacy.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:medicine_categories,name']);
        MedicineCategory::create($request->all());
        return redirect()->route('medicine-categories.index')->with('success','Category added.');
    }

    public function edit(MedicineCategory $medicine_category)
    {
        return view('admin.pharmacy.categories.edit', compact('medicine_category'));
    }

    public function update(Request $request, MedicineCategory $medicine_category)
    {
        $medicine_category->update($request->all());
        return redirect()->route('medicine-categories.index')->with('success','Updated.');
    }

    public function destroy(MedicineCategory $medicine_category)
    {
        $medicine_category->delete();
        return back()->with('success','Category deleted.');
    }
}
