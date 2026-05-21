<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::paginate(15);
        return view('admin.pharmacy.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.pharmacy.suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Supplier::create($request->all());
        return redirect()->route('suppliers.index')->with('success','Supplier added.');
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.pharmacy.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $supplier->update($request->all());
        return redirect()->route('suppliers.index')->with('success','Updated.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return back()->with('success','Deleted.');
    }
}
