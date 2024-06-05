<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * PermissionController constructor.
     * Applying middleware to controller methods for permission checks.
     */
    public function __construct()
    {
        $this->middleware('permission:view permission', ['only' => ['index']]);
        $this->middleware('permission:create permission', ['only' => ['create', 'store']]);
        $this->middleware('permission:update permission', ['only' => ['update', 'edit']]);
        $this->middleware('permission:delete permission', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the permissions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::get();
        return view('role-permission.permission.index', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for creating a new permission.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('role-permission.permission.create');
    }

    /**
     * Store a newly created permission in storage.
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
                'unique:permissions,name'
            ]
        ]);

        Permission::create([
            'name' => $request->name
        ]);

        return redirect('permissions')->with('status', 'Permission created successfuly!!');
    }

    /**
     * Show the form for editing the specified permission.
     *
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('role-permission.permission.edit', [
            'permission' => $permission
        ]);
    }

    /**
     * Update the specified permission in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\Permission\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name'
            ]
        ]);

        $permission->update([
            'name' => $request->name
        ]);

        return redirect('permissions')->with('status', 'Permission updated successfuly!!');
    }

    /**
     * Remove the specified permission from storage.
     *
     * @param  int  $permissionId
     * @return \Illuminate\Http\Response
     */
    public function destroy($permissionId)
    {
        $permission = Permission::find($permissionId);
        $permission->delete();

        return redirect('permissions')->with('status', 'Permission Deleted successfuly!!');
    }
}
