<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicineUnit;
use Illuminate\Http\Request;

class MedicineUnitController extends Controller
{
    public function index()
    {
        $units = MedicineUnit::paginate(15);
        return view('admin.pharmacy.units.index', compact('units'));
    }

    public function create()
    {
        return view('admin.pharmacy.units.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:medicine_units,name']);
        MedicineUnit::create($request->all());
        return redirect()->route('medicine-units.index')->with('success','Unit added.');
    }

    public function edit(MedicineUnit $medicine_unit)
    {
        return view('admin.pharmacy.units.edit', compact('medicine_unit'));
    }

    public function update(Request $request, MedicineUnit $medicine_unit)
    {
        $medicine_unit->update($request->all());
        return redirect()->route('medicine-units.index')->with('success','Updated.');
    }

    public function destroy(MedicineUnit $medicine_unit)
    {
        $medicine_unit->delete();
        return back()->with('success','Deleted.');
    }
}
