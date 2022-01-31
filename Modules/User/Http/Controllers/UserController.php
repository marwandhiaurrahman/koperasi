<?php

namespace Modules\Role\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admin');
    }
    public function index(Request $request)
    {
        $roles = Role::with(['permissions'])->paginate(20);
        $permissions = Permission::class;
        $select = $permissions::pluck('name', 'id')->toArray();
        $permissions = $permissions::paginate(20);
        return view('role::role_index', compact(['roles', 'permissions', 'select', 'request']));
    }
    public function edit($name)
    {
        $role = Role::with('permissions')->firstWhere('name', $name);
        $permissions = Permission::pluck('name', 'id');
        return view('role::role_edit', compact(['role', 'permissions']));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $request->id,
        ]);
        $role = Role::updateOrCreate(['id' => $request->id], ['name' => $request->name]);
        $role->syncPermissions();
        $role->syncPermissions($request->permission);
        Alert::success('Success Info', 'Success Message');
        return redirect()->route('admin.role.index');
    }
    public function destroy($id)
    {
        $role = Role::find($id);
        if ($role->users()->exists()) {
            Alert::error('Gagal Menghapus', 'Role masih memiliki user');
        } else {
            $role->delete();
            Alert::success('Success', 'Role Telah Dihapus');
        }
        return redirect()->route('admin.role.index');
    }
}
