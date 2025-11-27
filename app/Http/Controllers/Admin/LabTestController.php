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
        $tests = LabTest::with('category')->paginate(15);
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
        LabTest::create($request->all());
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
        $lab_test->update($request->all());
        return redirect()->route('lab-tests.index')->with('success','Updated.');
    }
}
