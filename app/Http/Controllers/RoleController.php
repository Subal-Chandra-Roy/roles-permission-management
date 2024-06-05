<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * RoleController constructor.
     * Applying middleware to controller methods for permission checks.
     */
    public function __construct()
    {
        $this->middleware('permission:view role', ['only' => ['index']]);
        $this->middleware('permission:create role', ['only' => ['create', 'store', 'addPermissionToRole', 'givePermissionToRole']]);
        $this->middleware('permission:update role', ['only' => ['update', 'edit']]);
        $this->middleware('permission:delete role', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the roles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::get();
        return view('role-permission.role.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new role.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('role-permission.role.create');
    }

    /**
     * Store a newly created role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name'
            ]
        ]);

        Role::create([
            'name' => $request->name
        ]);

        return redirect('roles')->with('status', 'Role created successfuly!!');
    }

    /**
     * Show the form for editing the specified role.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('role-permission.role.edit', [
            'role' => $role
        ]);
    }

    /**
     * Update the specified role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name'
            ]
        ]);

        $role->update([
            'name' => $request->name
        ]);

        return redirect('roles')->with('status', 'Role updated successfuly!!');
    }

    /**
     * Remove the specified role from storage.
     *
     * @param  int  $roleId
     * @return \Illuminate\Http\Response
     */
    public function destroy($roleId)
    {
        $role = Role::find($roleId);
        $role->delete();

        return redirect('roles')->with('status', 'Role Deleted successfuly!!');
    }

    /**
     * Show the form for adding permissions to the specified role.
     *
     * @param  int  $roleId
     * @return \Illuminate\Http\Response
     */
    public function addPermissionToRole($roleId)
    {
        $permissions = Permission::get();
        $role = Role::findOrFail($roleId);
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('role-permission.role.add-permissions', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Assign the specified permissions to the role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $roleId
     * @return \Illuminate\Http\Response
     */
    public function givePermissionToRole(Request $request, $roleId)
    {
        $request->validate([
            'permission' => 'required'
        ]);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);

        return redirect()->back()->with('status', 'Permission added to Role');
    }
}
