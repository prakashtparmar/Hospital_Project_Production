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
            'name'        => 'required|unique:departments,name',
            'code'        => 'nullable|max:10|regex:/^[A-Z0-9\-]+$/|unique:departments,code',
            'status'      => 'required|in:0,1',
            'description' => 'nullable',
        ]);

        $code = $request->code ?: $this->generateDepartmentCode();

        Department::create([
            'name'        => $request->name,
            'code'        => $code,
            'status'      => $request->status,
            'description' => $request->description,
        ]);

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
            'name'        => 'required|unique:departments,name,' . $department->id,
            'code'        => 'nullable|max:10|regex:/^[A-Z0-9\-]+$/|unique:departments,code,' . $department->id,
            'status'      => 'required|in:0,1',
            'description' => 'nullable',
        ]);

        $code = $request->code ?: $department->code ?: $this->generateDepartmentCode();

        $department->update([
            'name'        => $request->name,
            'code'        => $code,
            'status'      => $request->status,
            'description' => $request->description,
        ]);

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

    /**
     * ✅ Auto-generate sequential department code: DEPT-001
     */
    private function generateDepartmentCode(): string
    {
        $lastCode = Department::withTrashed()
            ->where('code', 'like', 'DEPT-%')
            ->orderByRaw('CAST(SUBSTRING(code, 6) AS UNSIGNED) DESC')
            ->value('code');

        $number = $lastCode
            ? (int) substr($lastCode, 5) + 1
            : 1;

        return 'DEPT-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}
