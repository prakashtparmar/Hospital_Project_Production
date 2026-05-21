<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabTest;
use App\Models\LabTestParameter;
use Illuminate\Http\Request;

class LabTestParameterController extends Controller
{
    public function index(LabTest $lab_test)
    {
        $parameters = $lab_test->parameters()->paginate(15);
        return view('admin.lab.parameters.index', compact('lab_test', 'parameters'));
    }

    public function create(LabTest $lab_test)
    {
        return view('admin.lab.parameters.create', compact('lab_test'));
    }

    public function store(Request $request, LabTest $lab_test)
    {
        $request->validate([
            'name' => 'required|array|min:1',
            'name.*' => 'required|string|max:255',
            'unit.*' => 'nullable|string|max:100',
            'ref.*' => 'nullable|string|max:255',
        ]);

        foreach ($request->name as $i => $name) {
            $name = trim($name);
            if ($name === '') {
                continue;
            }

            LabTestParameter::create([
                'test_id' => $lab_test->id,
                'name' => $name,
                'unit' => $request->unit[$i] ?? null,
                'reference_range' => $request->ref[$i] ?? null,
            ]);
        }

        return redirect()->route('lab.parameters.index', $lab_test->id)
            ->with('success', 'Parameters added.');
    }

    public function edit(LabTest $lab_test, LabTestParameter $parameter)
    {
        $this->guardParameterBelongsToTest($lab_test, $parameter);

        return view('admin.lab.parameters.edit', compact('lab_test', 'parameter'));
    }

    public function update(Request $request, LabTest $lab_test, LabTestParameter $parameter)
    {
        $this->guardParameterBelongsToTest($lab_test, $parameter);

        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string|max:100',
            'reference_range' => 'nullable|string|max:255',
        ]);

        $parameter->update($request->all());

        return redirect()->route('lab.parameters.index', $lab_test->id)
            ->with('success', 'Parameter updated.');
    }

    public function destroy(LabTest $lab_test, LabTestParameter $parameter)
    {
        $this->guardParameterBelongsToTest($lab_test, $parameter);

        $parameter->delete();

        return redirect()->route('lab.parameters.index', $lab_test->id)
            ->with('success', 'Parameter deleted.');
    }

    protected function guardParameterBelongsToTest(LabTest $lab_test, LabTestParameter $parameter)
    {
        if ($parameter->test_id !== $lab_test->id) {
            abort(404);
        }
    }
}
