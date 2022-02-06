<?php

namespace Modules\Simpanan\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Anggota\Entities\Anggota;
use Modules\Transaksi\Entities\JenisTransaksi;
use Modules\Transaksi\Entities\Transaksi;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;

class SimpananAnggotaController extends Controller
{
    public function index(Request $request)
    {
        $id = auth()->user()->anggota->id;
        if (is_null($request->periode)) {
            $request['periode'] = Carbon::today()->format('d-m-Y') . ' - ' . Carbon::today()->format('d-m-Y');
        }
        $tanggal = explode(' - ', $request->periode);
        $tanggal_awal = Carbon::parse($tanggal[0])->startOfDay();
        $tanggal_akhir = Carbon::parse($tanggal[1])->endOfDay();
        $anggota = Anggota::with(['user'])->findOrFail($id);
        $transaksis = Transaksi::with(['anggota', 'jenis_transaksi'])
            ->whereHas('jenis_transaksi', function ($query) {
                $query->where('group', 'simpanan');
            })
            // ->whereDate('created_at', '>=', $tanggal_awal)
            // ->whereDate('created_at', '<=', $tanggal_akhir)
            ->where('anggota_id', $id)
            ->orderByDesc('created_at')
            ->paginate();
        $jenis_simpanan = JenisTransaksi::where('group', 'simpanan')->get();
        return view('simpanan::simpanan_anggota_show', [
            'transaksis' => $transaksis,
            'request' => $request,
            'anggota' => $anggota,
            'jenis_simpanan' => $jenis_simpanan,
            'i' => (request()->input('page', 1) - 1) * $transaksis->perPage()
        ]);
    }

    public function create()
    {
        return view('anggota::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:transaksis',
            'tanggal' => 'required|date',
            'anggota_id' => 'required',
            'jenis' => 'required',
            'tipe' => 'required',
            'nominal' => 'required',
            'validasi' => 'required',
            'keterangan' => 'required',
            // 'user_id' => 'required',
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
            'user_id' => $request->user_id,
        ]);
        // $simpanan = $request->anggota_id;
        Alert::success('Success Info', 'Success Message');
        return redirect()->route('anggota.simpanan.index');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        return view('anggota::edit');
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
