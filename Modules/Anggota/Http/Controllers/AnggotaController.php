<?php

namespace Modules\Anggota\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Anggota\Entities\Anggota;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $time = Carbon::now();
        $anggotas = Anggota::get();
        $kodeanggota =  $time->year . $time->month . str_pad(rand(1000, 9999) + 1, 4, '0', STR_PAD_LEFT);

        $roles = Role::pluck('name', 'name')->all();
        return view('anggota::admin.index', compact(['anggotas', 'kodeanggota', 'roles']))->with(['i' => 0]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('anggota::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'alamat' => 'required',
            'role' => 'required',
            'tipe' => 'required',
            'kode' => 'required|unique:anggotas',
            'phone' => 'required|numeric',
            'email' => 'required|email|unique:users',
            'username' => 'required|alpha_dash|unique:users',
            'password' => 'required|min:6',
        ]);

        $request['password'] =  Hash::make($request->password);
        $user = User::updateOrCreate($request->only([
            'name',
            'alamat',
            'phone',
            'email',
            'username',
            'password',
        ]));
        $user->assignRole($request->role);
        Anggota::updateOrCreate([
            'kode' => $request->kode,
            'tipe' => $request->tipe,
            'user_id' => $user->id,
        ]);

        Alert::success('Success Info', 'Success Message');
        return redirect()->route('anggota.index')->with('success', 'IT WORKS!');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('anggota::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(User $user)
    {
        return view('anggota::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
