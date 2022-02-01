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
        $anggota = $user->anggota;
        return view('anggota::anggota_edit', [
            'anggota' => $anggota,
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
        $kodetransaksi =  $time->year . $time->month . $time->day . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);
        $request['kode'] = $kodetransaksi;
        $request['tanggal'] = $time;
        $request['anggota_id'] = $user->id;
        $request['jenis'] = 'Simpanan Pokok';
        $request['tipe'] = 'Debit';
        $request['nominal'] = '100000';
        $request['validasi'] = 0;
        $request['keterangan'] = 'Biaya Pendaftaran';

        $request->validate([
            'kode' => 'required|unique:transaksis',
            'tanggal' => 'required|date',
            'anggota_id' => 'required',
            'jenis' => 'required',
            'tipe' => 'required',
            'nominal' => 'required',
            'validasi' => 'required',
            'keterangan' => 'required',
        ]);

        if ($request->tipe == "Kredit") {
        }
        $transaksi = Transaksi::updateOrCreate([
            'kode' => $request->kode,
            'tanggal' => $request->tanggal,
            'anggota_id' => $request->anggota_id,
            'jenis' => $request->jenis,
            'tipe' => $request->tipe,
            'nominal' => $request->nominal,
            'validasi' => $request->validasi,
            'keterangan' => $request->keterangan,
        ]);
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
            'status' => $request->status,
        ]));
        Alert::success('Success Info', 'Anggota Telah Disimpan');
        return redirect()->route('admin.anggota.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        $user->anggota->delete();
        Alert::success('Success Info', 'Anggota Telah Dihapus');
        return redirect()->route('admin.anggota.index');
    }
}
