<?php

namespace Modules\Pinjaman\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Anggota\Entities\Anggota;
use Modules\Pinjaman\Entities\Pinjaman;
use Modules\Transaksi\Entities\JenisTransaksi;
use Modules\Transaksi\Entities\Transaksi;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;

class PinjamanAnggotaController extends Controller
{
    public function index(Request $request)
    {
        if (is_null($request->periode)) {
            $request['periode'] = Carbon::today()->format('d-m-Y') . ' - ' . Carbon::today()->format('d-m-Y');
        }
        $tanggal = explode(' - ', $request->periode);
        $tanggal_awal = Carbon::parse($tanggal[0])->startOfDay();
        $tanggal_akhir = Carbon::parse($tanggal[1])->endOfDay();

        $pinjamans = Pinjaman::with(['anggota', 'transaksis'])
            ->where('anggota_id', auth()->user()->anggota->id)
            ->paginate();

        // dd(auth()->user()->anggota->id);

        $anggotas = Anggota::with(['user', 'transaksis'])->latest()->get();

        $transaksis = Transaksi::with(['anggota', 'jenis_transaksi'])
            ->whereHas('jenis_transaksi', function ($query) {
                $query->where('group', 'pinjaman');
            })
            ->whereDate('created_at', '>=', $tanggal_awal)
            ->whereDate('created_at', '<=', $tanggal_akhir)
            ->orderByDesc('created_at')
            ->paginate();

        $jenis_transaksis = JenisTransaksi::where('group', 'pinjaman')->pluck('name', 'kode')->toArray();
        return view('pinjaman::pinjaman_anggota_index', [
            'transaksis' => $transaksis,
            'request' => $request,
            'anggotas' => $anggotas,
            'jenis_transaksis' => $jenis_transaksis,
            'pinjamans' => $pinjamans,
            'i' => (request()->input('page', 1) - 1) * $transaksis->perPage()
        ]);
    }
    public function show($id, Request $request)
    {
        if (is_null($request->periode)) {
            $request['periode'] = Carbon::today()->format('d-m-Y') . ' - ' . Carbon::today()->format('d-m-Y');
        }
        $tanggal = explode(' - ', $request->periode);
        $tanggal_awal = Carbon::parse($tanggal[0])->startOfDay();
        $tanggal_akhir = Carbon::parse($tanggal[1])->endOfDay();
        $pinjaman = Pinjaman::with(['anggota', 'transaksis', 'anggota.user'])->findOrFail($id);
        $transaksis = $pinjaman->transaksis;
        $anggota = $pinjaman->anggota;
        $jenis_transaksis = JenisTransaksi::where('group', 'angsuran')->pluck('name','kode')->toArray();
        return view('pinjaman::pinjaman_anggota_show', [
            'transaksis' => $transaksis,
            'request' => $request,
            'pinjaman' => $pinjaman,
            'anggota' => $anggota,
            'jenis_transaksis' => $jenis_transaksis,
            'i' => 0,
        ]);
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
