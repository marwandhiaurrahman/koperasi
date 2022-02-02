<?php

namespace Modules\Anggota\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Anggota\Entities\Anggota;
use Modules\Transaksi\Entities\Transaksi;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Modules\Transaksi\Http\Controllers\TransaksiController;

class AnggotaController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admin|pengawas', ['only' => ['index']]);
        $this->middleware('permission:admin', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }
    public function index(Request $request)
    {
        $time = Carbon::now();
        $anggotas = Anggota::with(['user'])->latest()->paginate();
        $kodeanggota =  $time->year . $time->month . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
        $roles = Role::pluck('name', 'name')->all();
        return view('anggota::anggota_index', [
            'request' => $request,
            'anggotas' => $anggotas,
            'kodeanggota' => $kodeanggota,
            'roles' => $roles,
            'i' => 0,
        ]);
    }
    public function edit($id)
    {
        $user = User::with(['anggota'])->findOrFail($id);
        return view('anggota::anggota_edit', [
            'user' => $user,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'tipe' => 'required',
            'kode' => 'required|unique:anggotas,kode,' . $request->id,
            'username' => 'required|alpha_dash|unique:users,username,' . $request->id,
            'email' => 'required|email|unique:users,email,' . $request->id,
            'password' => 'min:6',
        ]);

        if (!empty($request['password'])) {
            $request['password'] = Hash::make($request['password']);
        } else {
            $request = Arr::except($request, array('password'));
        }
        $user = User::updateOrCreate(['id' => $request->id], $request->except(['_token', 'id', 'role']));
        $user->assignRole();
        $user->assignRole($request->role);
        $user->anggota()->save(Anggota::updateOrCreate(['kode' => $request->kode,], [
            'tipe' => $request->tipe,
            'user_id' => $user->id,
        ]));
        $time = Carbon::now();
        $request['tanggal'] = $time;
        $request['anggota_id'] = $user->anggota->id;
        $request['jenis'] = 'SP';
        $request['tipe'] = 'Debit';
        $request['nominal'] = '100000';
        $request['keterangan'] = 'Biaya Pendaftaran';
        $request['validasi'] = 'Belum';

        $request->validate([
            'tanggal' => 'required|date',
            'anggota_id' => 'required',
            'jenis' => 'required',
            'tipe' => 'required',
            'nominal' => 'required',
        ]);

        $transaksi = new TransaksiController();
        $transaksi->store($request);
        Alert::success('Success Info', 'Anggota Telah Disimpan');
        return redirect()->route('admin.anggota.index');
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'tipe' => 'required',
            'status' => 'required',
            'kode' => 'required|unique:anggotas,kode,' . $request->anggota_id,
            'username' => 'required|alpha_dash|unique:users,username,' . $request->id,
            'email' => 'required|email|unique:users,email,' . $request->id,
            'password' => 'min:6',
        ]);
        if (!empty($request['password'])) {
            $request['password'] = Hash::make($request['password']);
        } else {
            $request = Arr::except($request, array('password'));
        }
        $user = User::updateOrCreate(['id' => $request->id], $request->except(['_token', 'id', 'role']));
        $user->assignRole();
        $user->assignRole($request->role);
        $user->anggota()->save(Anggota::updateOrCreate(['kode' => $request->kode,], [
            'tipe' => $request->tipe,
            'user_id' => $user->id,
            'status' => $request->status,
        ]));
        Alert::success('Success Info', 'Anggota Telah Disimpan');
        return redirect()->route('admin.anggota.index');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->anggota->delete();
        $user->delete();
        Alert::success('Success Info', 'Anggota Telah Dihapus');
        return redirect()->route('admin.anggota.index');
    }
}
