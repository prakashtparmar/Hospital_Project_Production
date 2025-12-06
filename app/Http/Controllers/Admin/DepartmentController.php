<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:departments.view')->only(['index', 'show']);
        $this->middleware('permission:departments.create')->only(['create', 'store']);
        $this->middleware('permission:departments.edit')->only(['edit', 'update']);
        $this->middleware('permission:departments.delete')->only(['destroy']);
    }

    public function index()
{
    $departments = Department::withTrashed()->latest()->get();
    return view('admin.departments.index', compact('departments'));
}

    public function create()
    {
        return view('admin.departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:departments,name',
            'code' => 'nullable|max:10',
            'status' => 'required',
            'description' => 'nullable'
        ]);

        Department::create($request->all());

        return redirect()
            ->route('departments.index')
            ->with('success', 'Department created successfully.');
    }

    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|unique:departments,name,' . $department->id,
            'code' => 'nullable|max:10',
            'status' => 'required',
            'description' => 'nullable'
        ]);

        $department->update($request->all());

        return redirect()
            ->route('departments.index')
            ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return back()->with('success', 'Department deleted.');
    }

    public function restore($id)
    {
        $department = Department::withTrashed()->findOrFail($id);
        $department->restore();

        return back()->with('success', 'Department restored successfully.');
    }

    public function forceDelete($id)
    {
        $department = Department::withTrashed()->findOrFail($id);
        $department->forceDelete();

        return back()->with('success', 'Department permanently deleted.');
    }


}
