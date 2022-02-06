<?php

namespace Modules\Pinjaman\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Pinjaman\Entities\Pinjaman;
use Modules\Transaksi\Entities\Transaksi;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;

class PinjamanAnggotaController extends Controller
{
    public function index()
    {
        dd('index');

        $time = Carbon::now();
        $kodetransaksi =  $time->year . $time->month . $time->day . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);

        $user = Auth::user();
        $users = Auth::user();
        $pinjamans = Pinjaman::where('anggota_id', $user->id)->latest()->get();
        $roles = Role::pluck('name', 'name')->all();

        $saldopinjaman = 0;
        $totalpinjaman = 0;
        foreach ($pinjamans as $value) {
            $saldopinjaman = $saldopinjaman + $value->saldo;
            $totalpinjaman = $totalpinjaman + $value->plafon;
        }

        $jenispinjaman = ['Bebas', 'Sebarkan'];
        return view('pinjaman::user.index', compact(['totalpinjaman', 'saldopinjaman', 'users', 'user', 'roles', 'pinjamans', 'kodetransaksi', 'jenispinjaman']))->with(['i' => 0]);
    }

    public function create()
    {
        return view('pinjaman::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:transaksis',
            'tanggal' => 'required|date',
            'anggota_id' => 'required',
            'jenis' => 'required',
            'waktu' => 'required',
            'plafon' => 'required',
            'validasi' => 'required',
            'keterangan' => 'required',
        ]);

        $request['tipe'] = 'Kredit';
        if ($request->tipe == "Kredit") {
        }

        $request['angsuranke'] = 0;
        $request['angsuran'] = 0;

        Transaksi::updateOrCreate([
            'kode' => $request->kode,
            'tanggal' => $request->tanggal,
            'anggota_id' => $request->anggota_id,
            'jenis' => 'Pinjaman',
            'tipe' => $request->tipe,
            'nominal' => $request->nominal,
            'validasi' => 0,
            'keterangan' => $request->keterangan,
        ]);

        $request->kode = $request->kode . '-' . $request->waktu;
        if ($request->jenis == 'Sebarkan') {
            $request->angsuran = $request->plafon /  $request->waktu;
        }
        Pinjaman::updateOrCreate([
            'kode' => $request->kode,
            'tanggal' => $request->tanggal,
            'anggota_id' => $request->anggota_id,
            'jenis' => $request->jenis,
            'plafon' => $request->plafon,
            'angsuran' => $request->angsuran,
            'jasa' => $request->jasa,
            'validasi' => $request->validasi,
            'waktu' => $request->waktu,
            'angsuranke' => $request->angsuranke,
            'saldo' => $request->jasa + $request->plafon,
            'validasi' => 0,
            'keterangan' => $request->keterangan,
            'user_id' => $request->user_id,
        ]);

        Alert::success('Success Info', 'Success Message');
        return redirect()->route('anggota.pinjaman.index')->with('success', 'Pinjaman Sudah Dibuat');
    }

    public function show($id)
    {
        return view('pinjaman::show');
    }

    public function edit($id)
    {
        return view('pinjaman::edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
