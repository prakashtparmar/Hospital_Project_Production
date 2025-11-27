<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bed;
use App\Models\Room;
use Illuminate\Http\Request;

class BedController extends Controller
{
    public function index()
    {
        $beds = Bed::with('room.ward')->paginate(10);
        return view('admin.beds.index', compact('beds'));
    }

    public function create()
    {
        return view('admin.beds.create', [
            'rooms' => Room::with('ward')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required',
            'bed_no' => 'required'
        ]);

        Bed::create($request->all());

        return redirect()->route('beds.index')->with('success', 'Bed added.');
    }

    public function edit(Bed $bed)
    {
        return view('admin.beds.edit', [
            'bed' => $bed,
            'rooms' => Room::with('ward')->get()
        ]);
    }

    public function update(Request $request, Bed $bed)
    {
        $request->validate([
            'room_id' => 'required',
            'bed_no' => 'required'
        ]);

        $bed->update($request->all());

        return redirect()->route('beds.index')->with('success', 'Bed updated.');
    }

    public function destroy(Bed $bed)
    {
        $bed->delete();
        return back()->with('success', 'Bed deleted.');
    }
}
