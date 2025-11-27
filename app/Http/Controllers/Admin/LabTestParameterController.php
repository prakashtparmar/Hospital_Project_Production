<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabTest;
use App\Models\LabTestParameter;
use Illuminate\Http\Request;

class LabTestParameterController extends Controller
{
    public function create(LabTest $lab_test)
    {
        return view('admin.lab.parameters.create', compact('lab_test'));
    }

    public function store(Request $request, LabTest $lab_test)
    {
        foreach ($request->name as $i => $name) {
            LabTestParameter::create([
                'test_id' => $lab_test->id,
                'name' => $name,
                'unit' => $request->unit[$i],
                'reference_range' => $request->ref[$i]
            ]);
        }

        return redirect()->route('lab-tests.index')->with('success','Parameters added.');
    }
}
