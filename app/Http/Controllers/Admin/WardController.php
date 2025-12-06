<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ward;
use Illuminate\Http\Request;

class WardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:wards.view')->only(['index']);
        $this->middleware('permission:wards.create')->only(['create', 'store']);
        $this->middleware('permission:wards.edit')->only(['edit', 'update']);
        $this->middleware('permission:wards.delete')->only(['destroy']);
    }

    /**
     * Ward List
     */
    public function index()
    {
        $wards = Ward::latest()->paginate(10);
        return view('admin.wards.index', compact('wards'));
    }

    /**
     * Create Ward Form
     */
    public function create()
    {
        return view('admin.wards.create');
    }

    /**
     * Store Ward
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:wards,name',
        ]);

        Ward::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('wards.index')
            ->with('success', 'Ward created successfully.');
    }

    /**
     * Edit Ward
     */
    public function edit(Ward $ward)
    {
        return view('admin.wards.edit', compact('ward'));
    }

    /**
     * Update Ward
     */
    public function update(Request $request, Ward $ward)
    {
        $request->validate([
            'name' => 'required|unique:wards,name,' . $ward->id,
        ]);

        $ward->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('wards.index')
            ->with('success', 'Ward updated successfully.');
    }

    /**
     * Delete Ward
     */
    public function destroy(Ward $ward)
    {
        $ward->delete();

        return back()
            ->with('success', 'Ward deleted successfully.');
    }
}
