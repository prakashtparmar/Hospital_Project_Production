<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabTest;
use App\Models\LabTestCategory;
use Illuminate\Http\Request;

class LabTestController extends Controller
{
    public function index()
    {
        $tests = LabTest::with('category')->withCount('parameters')->paginate(15);
        return view('admin.lab.tests.index', compact('tests'));
    }

    public function create()
    {
        return view('admin.lab.tests.create', [
            'categories' => LabTestCategory::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:lab_test_categories,id',
            'name' => 'required|string|max:255',
            'method' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:0,1',
        ]);

        LabTest::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'method' => $request->method,
            'price' => $request->price ?? 0,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('lab-tests.index')->with('success','Test added.');
    }

    public function edit(LabTest $lab_test)
    {
        return view('admin.lab.tests.edit', [
            'test' => $lab_test,
            'categories' => LabTestCategory::all()
        ]);
    }

    public function update(Request $request, LabTest $lab_test)
    {
        $request->validate([
            'category_id' => 'required|exists:lab_test_categories,id',
            'name' => 'required|string|max:255',
            'method' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:0,1',
        ]);

        $lab_test->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'method' => $request->method,
            'price' => $request->price ?? 0,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('lab-tests.index')->with('success','Updated.');
    }
}
