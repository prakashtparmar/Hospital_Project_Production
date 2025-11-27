<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ward;
use Illuminate\Http\Request;

class WardController extends Controller
{
    public function index()
    {
        $wards = Ward::latest()->paginate(10);
        return view('admin.wards.index', compact('wards'));
    }

    public function create()
    {
        return view('admin.wards.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:wards,name',
        ]);

        Ward::create($request->all());

        return redirect()->route('wards.index')->with('success', 'Ward created.');
    }

    public function edit(Ward $ward)
    {
        return view('admin.wards.edit', compact('ward'));
    }

    public function update(Request $request, Ward $ward)
    {
        $request->validate([
            'name' => 'required|unique:wards,name,' . $ward->id,
        ]);

        $ward->update($request->all());

        return redirect()->route('wards.index')->with('success', 'Ward updated.');
    }

    public function destroy(Ward $ward)
    {
        $ward->delete();
        return back()->with('success', 'Ward deleted.');
    }
}
