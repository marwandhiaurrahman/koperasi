<?php

namespace Modules\Transaksi\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Transaksi\Entities\Transaksi;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $time = Carbon::now();
        $kodetransaksi =  $time->year . $time->month . $time->day . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);

        $debittransaksi = [
            'Simpanan Pokok' => 'Simpanan Pokok',
            'Simpanan Wajib' => 'Simpanan Wajib',
            'Simpanan Mana Suka' => 'Simpanan Mana Suka',
            'Angsuran' => 'Angsuran',
            'Jasa' => 'Jasa',
            'Lainnya' => 'Lainnya',
        ];
        $kredittransaksi = [
            'Pinjaman' => 'Pinjaman',
            'Simpanan Pokok' => 'Simpanan Pokok',
            'Simpanan Wajib' => 'Simpanan Wajib',
            'Simpanan Mana Suka' => 'Simpanan Mana Suka',
            'Lainnya' => 'Lainnya',
        ];
        $users = User::latest()->role('Anggota')->pluck('name', 'id')->all();
        // dd($users);
        $transaksis = Transaksi::latest()->get();
        $debittotal = 0;
        $kredittotal = 0;
        foreach ($transaksis as $key => $value) {
            if ($value->tipe == "Debit") {
                $debittotal = $debittotal + $value->nominal;
            }
            if ($value->tipe == "Kredit") {
                $kredittotal =  $kredittotal + $value->nominal;
            }
        }
        // dd($debittotal-$kredittotal);
        return view('transaksi::admin.index', compact(['users', 'transaksis', 'debittransaksi', 'debittotal', 'kredittotal', 'kredittransaksi', 'kodetransaksi']))->with(['i' => 0]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('transaksi::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
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
            'user_id' => 'required',
        ]);
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

        Alert::success('Success Info', 'Success Message');
        return redirect()->route('transaksi.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('transaksi::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('transaksi::edit');
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
