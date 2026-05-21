<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:users.view')->only('index');
        $this->middleware('permission:users.create')->only(['create','store']);
        $this->middleware('permission:users.edit')->only(['edit','update']);
        $this->middleware('permission:users.delete')->only('destroy');
    }

    public function index()
{
    $users = User::with('roles')
        ->leftJoin('sessions', function ($join) {
            $join->on('sessions.user_id', '=', 'users.id')
                 ->whereRaw('sessions.last_activity = (
                     SELECT MAX(last_activity)
                     FROM sessions
                     WHERE sessions.user_id = users.id
                 )');
        })
        ->select(
            'users.*',
            'sessions.ip_address',
            'sessions.user_agent',
            'sessions.last_activity'
        )
        ->orderByDesc('users.id')
        ->get();

    $roles = Role::all();

    return view('admin.users.index', compact('users','roles'));
}


    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name'                 => $request->name,
            'email'                => $request->email,
            'password'             => Hash::make($request->password),
            'mobile'               => $request->mobile,
            'user_code'            => $request->user_code,
            'user_type'            => $request->user_type,
            'is_active'            => $request->is_active ?? 1,
            'gender'               => $request->gender,
            'marital_status'       => $request->marital_status,
            'date_of_birth'        => $request->date_of_birth,
            'joining_date'         => $request->joining_date,
            'emergency_contact_no' => $request->emergency_contact_no,
            'address'              => $request->address,
        ]);

        if ($request->hasFile('image')) {
            $user->update([
                'image' => $request->file('image')->store('users', 'public')
            ]);
        }

        if ($request->roles) {
            $user->syncRoles($request->roles);
        }

        // ✅ SAFE ACTIVITY LOG
        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties([
                'attributes' => $request->except(['password','password_confirmation']),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ])
            ->log('User created');

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'                 => $request->name,
            'email'                => $request->email,
            'mobile'               => $request->mobile,
            'user_code'            => $request->user_code,
            'user_type'            => $request->user_type,
            'is_active'            => $request->is_active ?? 0,
            'gender'               => $request->gender,
            'marital_status'       => $request->marital_status,
            'date_of_birth'        => $request->date_of_birth,
            'joining_date'         => $request->joining_date,
            'emergency_contact_no' => $request->emergency_contact_no,
            'address'              => $request->address,
        ]);

        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        if ($request->hasFile('image')) {
            $user->update([
                'image' => $request->file('image')->store('users','public')
            ]);
        }

        if ($request->roles) {
            $user->syncRoles($request->roles);
        }

        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties([
                'changed' => $user->getChanges(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ])
            ->log('User updated');

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties([
                'user_id' => $user->id,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ])
            ->log('User deleted');

        $user->delete();

        return back()->with('success', 'User deleted.');
    }
}
