<?php

namespace Modules\User\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admin-role|pengawas-role', ['only' => ['index']]);
        $this->middleware('permission:admin-role', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }

    public function profile()
    {
        $user = Auth::user();

        return view('user::profile', compact(['user']));
    }

    public function profile_update()
    {
        $user = Auth::user();
        dd($user);
        return view('user::profile', compact(['user']));
    }

    public function index()
    {
        $users = User::latest()->get();
        $roles = Role::pluck('name', 'name')->all();
        return view('user::admin.index', compact(['users', 'roles']))->with(['i' => 0]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'alamat' => 'required',
            'role' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email|unique:users',
            'username' => 'required|alpha_dash|unique:users',
            'password' => 'required|min:6',
        ]);

        $request['password'] =  Hash::make($request->password);

        $user = User::updateOrCreate(['id', $request->id], $request->only([
            'name',
            'alamat',
            'phone',
            'email',
            'username',
            'password',
        ]));
        $user->assignRole($request->role);

        Alert::success('Success Info', 'Success Message');
        return redirect()->route('admin.user.index')->with('success', 'IT WORKS!');
    }
    public function edit($id)
    {
        $user = User::find($id);
        $user['role'] = $user->roles->first()->name;
        return response()->json([
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(User $user)
    {
        $user->delete();
        Alert::success('Success Info', 'Success Message');
        return redirect()->route('admin.user.index')->with('success', 'IT WORKS!');
    }
}
