<?php

namespace Modules\Transaksi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Transaksi\Entities\JenisTransaksi;
use RealRashid\SweetAlert\Facades\Alert;


class JenisTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $jenis_transaksis = JenisTransaksi::paginate();
        return view('transaksi::jenis_transaksi_index', [
            'request' => $request,
            'jenis_transaksis' => $jenis_transaksis,
            'i' => ($request->input('page', 1) - 1) * 5,
        ]);

        return view('transaksi::index');
    }
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:jenis_transaksis,kode,'.$request->id,
            'name' => 'required',
            'status' => 'required',
        ]);
        JenisTransaksi::updateOrCreate(['id' => $request->id], [
            'name' => $request->name,
            'kode' => $request->kode,
            'group' => $request->group,
            'status' => $request->status,
        ]);
        Alert::success('Success', 'Data Telah Disimpan');
        return redirect()->route('admin.jenis_transaksi.index');
        dd($request->all());
    }
    public function edit($id)
    {
        $jenis_transaksi = JenisTransaksi::find($id);
        return view('transaksi::jenis_transaksi_edit', [
            'jenis_transaksi' => $jenis_transaksi,
        ]);
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
