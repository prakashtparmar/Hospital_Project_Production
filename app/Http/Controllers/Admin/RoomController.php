<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Ward;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('ward')->paginate(10);
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create', [
            'wards' => Ward::where('status', 1)->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'ward_id' => 'required',
            'room_no' => 'required'
        ]);

        Room::create($request->all());

        return redirect()->route('rooms.index')->with('success', 'Room added.');
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', [
            'room' => $room,
            'wards' => Ward::where('status', 1)->get()
        ]);
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'ward_id' => 'required',
            'room_no' => 'required'
        ]);

        $room->update($request->all());

        return redirect()->route('rooms.index')->with('success', 'Room updated.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return back()->with('success', 'Room deleted.');
    }
}
