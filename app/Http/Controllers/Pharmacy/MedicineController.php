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
        return view('admin.pharmacy.medicines.index', [
            'medicines' => Medicine::with(['category','unit'])->paginate(20)
        ]);
    }

    public function create()
    {
        return view('admin.pharmacy.medicines.create', [
            'categories' => MedicineCategory::all(),
            'units' => MedicineUnit::all()
        ]);
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'category_id' => 'required',
            'unit_id' => 'required',
        ]);

        Medicine::create($req->all());

        return redirect()->route('medicines.index')
            ->with('success','Medicine created successfully');
    }

    public function edit(Medicine $medicine)
    {
        return view('admin.pharmacy.medicines.edit', [
            'medicine' => $medicine,
            'categories' => MedicineCategory::all(),
            'units' => MedicineUnit::all()
        ]);
    }

    public function update(Request $req, Medicine $medicine)
    {
        $medicine->update($req->all());

        return redirect()->route('medicines.index')
            ->with('success','Medicine updated');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();

        return back()->with('success','Medicine deleted');
    }
}
