<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Ward;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:rooms.view')->only(['index']);
        $this->middleware('permission:rooms.create')->only(['create', 'store']);
        $this->middleware('permission:rooms.edit')->only(['edit', 'update']);
        $this->middleware('permission:rooms.delete')->only(['destroy']);
    }

    /**
     * Room List
     */
    public function index()
    {
        $rooms = Room::with('ward')->paginate(10);
        $wards = Ward::where('status', 1)->get(); 
        return view('admin.rooms.index', compact('rooms','wards'));
    }

    /**
     * Create Room Form
     */
    public function create()
    {
        $wards = Ward::where('status', 1)->get();

        return view('admin.rooms.create', compact('wards'));
    }

    /**
     * Store Room
     */
    public function store(Request $request)
    {
        $request->validate([
            'ward_id' => 'required|exists:wards,id',
            'room_no' => 'required',
        ]);

        Room::create([
            'ward_id' => $request->ward_id,
            'room_no' => $request->room_no,
        ]);

        return redirect()
            ->route('rooms.index')
            ->with('success', 'Room added successfully.');
    }

    /**
     * Edit Room
     */
    public function edit(Room $room)
    {
        $wards = Ward::where('status', 1)->get();

        return view('admin.rooms.edit', compact('room', 'wards'));
    }

    /**
     * Update Room
     */
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'ward_id' => 'required|exists:wards,id',
            'room_no' => 'required',
        ]);

        $room->update([
            'ward_id' => $request->ward_id,
            'room_no' => $request->room_no,
        ]);

        return redirect()
            ->route('rooms.index')
            ->with('success', 'Room updated successfully.');
    }

    /**
     * Delete Room
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return back()
            ->with('success', 'Room deleted successfully.');
    }
}
