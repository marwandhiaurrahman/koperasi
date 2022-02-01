<?php

namespace Modules\Simpanan\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Simpanan\Entities\JenisSimpanan;
use RealRashid\SweetAlert\Facades\Alert;

class JenisSimpananController extends Controller
{
    public function index(Request $request)
    {
        $jenis_simpanans = JenisSimpanan::paginate();

        return view('simpanan::jenis_simpanan_index', [
            'request' => $request,
            'jenis_simpanans' => $jenis_simpanans,
            'i' => ($jenis_simpanans->currentPage() - 1) * $jenis_simpanans->perPage(),
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'kode' => 'required|unique:jenis_simpanans,kode,' . $request->id,
        ]);
        JenisSimpanan::updateOrCreate(['id' => $request->id], [
            'name' => $request->name,
            'kode' => $request->kode,
            'status' => $request->status,
        ]);
        Alert::success('Success', 'Data Telah Disimpan');
        return redirect()->route('admin.jenis_simpanan.index');
    }
    public function edit($id)
    {
        $jenis_simpanan = JenisSimpanan::find($id);
        return view('simpanan::jenis_simpanan_edit', [
            'jenis_simpanan' => $jenis_simpanan,
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
