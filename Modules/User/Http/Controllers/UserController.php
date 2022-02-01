<?php

namespace Modules\User\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;
use Modules\User\Entities\Agama;
use Modules\User\Entities\Gender;
use Modules\User\Entities\Perkawinan;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admin', ['only' => ['index', 'edit', 'store', 'destroy']]);
    }

    public function index(Request $request)
    {
        $users = User::with(['roles'])
            ->where(function ($query) use ($request) {
                $query->where('name', "like", "%" . $request->search . "%");
                $query->orWhere('nik', "like", "%" . $request->search . "%");
            })
            ->paginate(10);

        $roles = Role::pluck('name', 'id')->toArray();
        return view('user::user_index', compact(['users', 'request', 'roles']))->with(['i' => 0]);
    }
    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::pluck('name', 'id');
        return view('user::user_edit', compact(['user', 'roles']));
    }
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|alpha_dash|unique:users,username,' . $request->id,
            'nik' => 'unique:users,nik,' . $request->id,
            'name' => 'required',
            'role' => 'required',
        ]);

        if (!empty($request['password'])) {
            $request['password'] = Hash::make($request['password']);
        } else {
            $request = Arr::except($request, array('password'));
        }

        $user = User::updateOrCreate(['id' => $request->id], $request->except(['_token', 'id', 'role']));
        DB::table('model_has_roles')->where('model_id', $request->id)->delete();
        $user->assignRole($request->role);
        Alert::success('Success', 'Data Telah Disimpan');
        return redirect()->route('admin.user.index');
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        Alert::success('Success', 'User Telah Dihapus');
        return redirect()->route('admin.user.index');
    }
    public function profile()
    {
        $user = Auth::user();
        $roles = Role::pluck('name', 'name')->all();
        $genders = Gender::pluck('name', 'name')->all();
        $agamas = Agama::pluck('name', 'name')->all();
        $perkawinans = Perkawinan::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        $provinces = Province::pluck('name', 'id');
        $cities = City::where('province_code', $user->province_id)->pluck('name', 'id')->all();
        $districts = District::where('city_code', $user->city_id)->pluck('name', 'id')->all();
        $villages = Village::where('district_code', $user->district_id)->pluck('name', 'id')->all();
        return view('user::profile', compact(
            'user',
            'roles',
            'userRole',
            'genders',
            'agamas',
            'perkawinans',
            'provinces',
            'cities',
            'districts',
            'villages',
        ));
    }
    public function profile_update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required',
            'email' => 'unique:users,email,' . $user->id,
            'username' => 'required|alpha_dash|unique:users,username,' . $user->id,
        ]);
        $user->update($request->all());
        Alert::success('Success', 'Data Telah Disimpan');
        return redirect()->route('profil');
    }
    public function get_provinsi()
    {
        $url = "http://127.0.0.1:8000/api/referensi/propinsi";
        // dd($url);
        $response = Http::get($url);
        dd($response);
        $response = $response->json();
    }
}
