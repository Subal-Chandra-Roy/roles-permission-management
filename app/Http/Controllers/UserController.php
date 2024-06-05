<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * UserController constructor.
     * Applying middleware to controller methods for permission checks.
     */
    public function __construct()
    {
        $this->middleware('permission:view user', ['only' => ['index']]);
        $this->middleware('permission:create user', ['only' => ['create', 'store']]);
        $this->middleware('permission:update user', ['only' => ['update', 'edit']]);
        $this->middleware('permission:delete user', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();
        return view('role-permission.user.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('role-permission.user.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'roles' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles($request->roles);

        return redirect('/users')->with('status', 'User created successfully with roles');
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();
        return view('role-permission.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
            'roles' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if (!empty($request->password)) {
            $data += [
                'password' => $request->password
            ];
        }

        $user->update($data);
        $user->syncRoles($request->roles);

        return redirect('/users')->with('status', 'User updated successfully with roles');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect('/users')->with('status', 'User Deleted Successfully');
    }
}
