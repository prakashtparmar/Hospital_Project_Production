<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\MedicineCategory;
use App\Models\MedicineUnit;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::with('category','unit')->paginate(15);
        return view('admin.pharmacy.medicines.index', compact('medicines'));
    }

    public function create()
    {
        return view('admin.pharmacy.medicines.create', [
            'categories' => MedicineCategory::where('status',1)->get(),
            'units' => MedicineUnit::where('status',1)->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:medicines,name',
            'category_id' => 'required',
            'unit_id' => 'required'
        ]);

        Medicine::create($request->all());

        return redirect()->route('medicines.index')->with('success','Medicine added.');
    }

    public function edit(Medicine $medicine)
    {
        return view('admin.pharmacy.medicines.edit', [
            'medicine' => $medicine,
            'categories' => MedicineCategory::all(),
            'units' => MedicineUnit::all()
        ]);
    }

    public function update(Request $request, Medicine $medicine)
    {
        $medicine->update($request->all());
        return redirect()->route('medicines.index')->with('success','Updated.');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return back()->with('success','Deleted.');
    }
}
