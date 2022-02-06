<?php

namespace Modules\Pinjaman\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pinjaman\Entities\Pinjaman;
use Modules\Transaksi\Entities\Transaksi;
use RealRashid\SweetAlert\Facades\Alert;

class AngsuranController extends Controller
{
    public function store(Request $request)
    {
        $time = Carbon::now();
        if (is_null($request->kode)) {
            $kodetransaksi = $request->jenis . $time->year . str_pad($time->month, 2, '0', STR_PAD_LEFT) . str_pad($time->day, 2, '0', STR_PAD_LEFT)  . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);
            $request['kode'] = $kodetransaksi;
        }
        $request['admin_id'] = auth()->user()->id;

        $request->validate([
            'kode' => 'required|unique:transaksis,kode,' . $request->id, //
            'tanggal' => 'required|date',
            'anggota_id' => 'required',
            'jenis' => 'required',
            'tipe' => 'required',
            'nominal' => 'required',
            'validasi' => 'required',
            'admin_id' => 'required', //
        ]);
        $transaksi = Transaksi::updateOrCreate(
            [
                'id' => $request->id,
                'kode' => $request->kode,
            ],
            [
                'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
                'anggota_id' => $request->anggota_id,
                'jenis' => $request->jenis,
                'tipe' => $request->tipe,
                'nominal' => $request->nominal,
                'validasi' => $request->validasi,
                'keterangan' => $request->keterangan,
                'admin_id' => $request->admin_id,
            ]
        );

        $pinjaman = Pinjaman::find($request->pinjaman_id);
        $saldo = $pinjaman->saldo - $request->nominal;
        if ($pinjaman->tipe == 0) {
            $sisa_angsuran = $pinjaman->sisa_angsuran - 1;
        }
        else {
            $sisa_angsuran = $pinjaman->sisa_angsuran ;
        }
        $pinjaman->update([
            'saldo' => $saldo,
            'sisa_angsuran' => $sisa_angsuran,
        ]);

        $pinjaman->transaksis()->attach($transaksi->id);

        return redirect()->back();
    }
}
