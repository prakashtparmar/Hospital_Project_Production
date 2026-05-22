<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RadiologyCategory;
use App\Models\RadiologyTest;
use Illuminate\Http\Request;

class RadiologyTestController extends Controller
{
    public function index()
    {
        $tests = RadiologyTest::with('category')->paginate(15);
        return view('admin.radiology.tests.index', compact('tests'));
    }

    public function create()
    {
        return view('admin.radiology.tests.create', [
            'categories' => RadiologyCategory::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:radiology_categories,id',
            'name' => 'required|string|max:255',
            'modality' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'nullable|in:0,1',
        ]);

        RadiologyTest::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'modality' => $request->modality,
            'price' => $request->price,
            'status' => (int) $request->input('status', 0) === 1 ? 1 : 0,
        ]);

        return redirect()->route('radiology-tests.index')->with('success','Test added.');
    }

    public function edit(RadiologyTest $radiology_test)
    {
        return view('admin.radiology.tests.edit', [
            'test' => $radiology_test,
            'categories' => RadiologyCategory::all()
        ]);
    }

    public function update(Request $request, RadiologyTest $radiology_test)
    {
        $request->validate([
            'category_id' => 'required|exists:radiology_categories,id',
            'name' => 'required|string|max:255',
            'modality' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'nullable|in:0,1',
        ]);

        $radiology_test->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'modality' => $request->modality,
            'price' => $request->price,
            'status' => (int) $request->input('status', 0) === 1 ? 1 : 0,
        ]);

        return redirect()->route('radiology-tests.index')->with('success','Updated.');
    }

    public function destroy(RadiologyTest $radiology_test)
    {
        $radiology_test->delete();

        return redirect()->route('radiology-tests.index')->with('success', 'Test deleted.');
    }
}
