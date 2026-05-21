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
        RadiologyTest::create($request->all());
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
        $radiology_test->update($request->all());
        return redirect()->route('radiology-tests.index')->with('success','Updated.');
    }
}
