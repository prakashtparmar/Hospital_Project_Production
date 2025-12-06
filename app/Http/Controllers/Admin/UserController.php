<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        // Load full user data + roles + latest session info
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
            ->orderBy('users.id', 'desc')
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
        // VALIDATION
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        // CREATE USER
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

        // IMAGE UPLOAD
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('users', 'public');
            $user->update(['image' => $path]);
        }

        // ASSIGN ROLES
        if ($request->roles) {
            $user->syncRoles($request->roles);
        }

        // 🔹 ACTIVITY LOG — USER CREATED
        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties([
                'attributes' => $request->all(),
                'ip'         => $request->ip(),
                'user_agent' => $request->userAgent(),
            ])
            ->log('User created');

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // VALIDATION
        $request->validate([
            'name'   => 'required',
            'email'  => 'required|email|unique:users,email,' . $user->id,
        ]);

        // UPDATE USER
        $user->update([
            'name'                 => $request->name,
            'email'                => $request->email,

            'mobile'               => $request->mobile,
            'user_code'            => $request->user_code,
            'user_type'            => $request->user_type,
            'is_active'            => $request->is_active,

            'gender'               => $request->gender,
            'marital_status'       => $request->marital_status,
            'date_of_birth'        => $request->date_of_birth,
            'joining_date'         => $request->joining_date,
            'emergency_contact_no' => $request->emergency_contact_no,
            'address'              => $request->address,
        ]);

        // UPDATE PASSWORD IF GIVEN
        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // UPDATE IMAGE
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('users', 'public');
            $user->update(['image' => $path]);
        }

        // UPDATE ROLES
        if ($request->roles) {
            $user->syncRoles($request->roles);
        }

        // 🔹 ACTIVITY LOG — USER UPDATED
        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties([
                'changed'    => $user->getChanges(),
                'ip'         => $request->ip(),
                'user_agent' => $request->userAgent(),
            ])
            ->log('User updated');

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // 🔹 ACTIVITY LOG — USER DELETED
        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties([
                'user_id'    => $user->id,
                'ip'         => request()->ip(),
                'user_agent' => request()->userAgent(),
            ])
            ->log('User deleted');

        $user->delete();

        return back()->with('success', 'User deleted.');
    }
}
