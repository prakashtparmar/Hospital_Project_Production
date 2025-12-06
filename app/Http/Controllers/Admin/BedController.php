<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bed;
use App\Models\Room;
use Illuminate\Http\Request;

class BedController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:beds.view')->only(['index']);
        $this->middleware('permission:beds.create')->only(['create', 'store']);
        $this->middleware('permission:beds.edit')->only(['edit', 'update']);
        $this->middleware('permission:beds.delete')->only(['destroy']);
    }

    /**
     * Bed List
     */
    public function index()
    {
        $beds = Bed::with('room.ward')->paginate(10);
        $rooms = Room::with('ward')->get();
        return view('admin.beds.index', compact('beds','rooms'));
    }

    /**
     * Create Bed Form
     */
    public function create()
    {
        $rooms = Room::with('ward')->get();

        return view('admin.beds.create', compact('rooms'));
    }

    /**
     * Store Bed
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'bed_no'  => 'required',
        ]);

        Bed::create([
            'room_id' => $request->room_id,
            'bed_no'  => $request->bed_no,
        ]);

        return redirect()
            ->route('beds.index')
            ->with('success', 'Bed added successfully.');
    }

    /**
     * Edit Bed
     */
    public function edit(Bed $bed)
    {
        $rooms = Room::with('ward')->get();

        return view('admin.beds.edit', compact('bed', 'rooms'));
    }

    /**
     * Update Bed
     */
    public function update(Request $request, Bed $bed)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'bed_no'  => 'required',
        ]);

        $bed->update([
            'room_id' => $request->room_id,
            'bed_no'  => $request->bed_no,
        ]);

        return redirect()
            ->route('beds.index')
            ->with('success', 'Bed updated successfully.');
    }

    /**
     * Delete Bed
     */
    public function destroy(Bed $bed)
    {
        $bed->delete();

        return back()
            ->with('success', 'Bed deleted successfully.');
    }
}
