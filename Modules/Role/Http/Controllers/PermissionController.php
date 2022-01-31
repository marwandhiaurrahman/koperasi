<?php

namespace Modules\Role\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admin');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|alpha_dash|unique:permissions,name,' . $request->id,
        ]);
        Permission::updateOrCreate(['id' => $request->id], ['name' => Str::slug($request->name)]);
        Alert::success('Success', 'Data Telah Disimpan');
        return redirect()->route('admin.role.index');
    }
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('role::permission_edit', compact(['permission']));
    }
    public function destroy($id)
    {
        $permission = Permission::find($id);
        if ($permission->roles()->exists()) {
            Alert::error('Gagal Menghapus', 'Permission masih memiliki role');
        } else {
            $permission->delete();
            Alert::success('Success', 'Permission Telah Dihapus');
        }
        return redirect()->route('admin.role.index');
    }
}
