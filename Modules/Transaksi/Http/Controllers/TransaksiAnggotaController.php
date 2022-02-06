<?php

namespace Modules\Transaksi\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Anggota\Entities\Anggota;
use Modules\Transaksi\Entities\JenisTransaksi;
use Modules\Transaksi\Entities\Transaksi;
use RealRashid\SweetAlert\Facades\Alert;

class TransaksiAnggotaController extends Controller
{
    public function index(Request $request)
    {
        if (is_null($request->periode)) {
            $request['periode'] = Carbon::today()->format('d-m-Y') . ' - ' . Carbon::today()->format('d-m-Y');
        }
        $tanggal = explode(' - ', $request->periode);
        $tanggal_awal = Carbon::parse($tanggal[0])->startOfDay();
        $tanggal_akhir = Carbon::parse($tanggal[1])->endOfDay();
        $transaksis = Transaksi::whereDate('created_at', '>=', $tanggal_awal)
            ->whereDate('created_at', '<=', $tanggal_akhir)
            ->orderByDesc('created_at')
            ->where('anggota_id', auth()->user()->anggota->id)
            ->paginate();
        $nominal_debit = Transaksi::whereDate('created_at', '>=', $tanggal_awal)
            ->whereDate('created_at', '<=', $tanggal_akhir)
            ->where('tipe', 'Debit')
            ->where('anggota_id', auth()->user()->anggota->id)
            ->sum('nominal');
        $nominal_kredit = Transaksi::whereDate('created_at', '>=', $tanggal_awal)
            ->whereDate('created_at', '<=', $tanggal_akhir)
            ->where('tipe', 'Kredit')
            ->where('anggota_id', auth()->user()->anggota->id)
            ->sum('nominal');
        $anggotas = Anggota::with(['user'])->latest()->get();
        $jenis_transaksis = JenisTransaksi::pluck('name', 'kode')->toArray();
        return view('transaksi::transaksi_anggota_index', [
            'transaksis' => $transaksis,
            'request' => $request,
            'anggotas' => $anggotas,
            'nominal_debit' => $nominal_debit,
            'nominal_kredit' => $nominal_kredit,
            'jenis_transaksis' => $jenis_transaksis,
            'i' => (request()->input('page', 1) - 1) * $transaksis->perPage()
        ]);
    }
}
