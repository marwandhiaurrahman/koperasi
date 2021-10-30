<?php

namespace Modules\Simpanan\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Transaksi\Entities\Transaksi;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;

class SimpananController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    function __construct()
    {
        $this->middleware('permission:admin-role|pengawas-role', ['only' => ['index', 'show']]);
        $this->middleware('permission:admin-role', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }
    public function index()
    {
        $users = User::role('Anggota')->latest()->get();
        $roles = Role::pluck('name', 'name')->all();
        $transaksis = Transaksi::latest()->get();
        $time = Carbon::now();

        return view('simpanan::admin.index', compact(['users', 'time', 'transaksis', 'roles']))->with(['i' => 0]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('simpanan::create');
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

        // dd($request->all());
        if ($request->tipe == "Kredit") {
            $request->nominal = -1 * $request->nominal;
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
        $simpanan = $request->anggota_id;

        Alert::success('Success Info', 'Success Message');
        return redirect()->route('admin.simpanan.show',compact('simpanan'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $user = User::find($id);
        $time = Carbon::now();
        $kodetransaksi =  $time->year . $time->month . $time->day . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);

        $debittransaksi = [
            'Simpanan Pokok' => 'Simpanan Pokok',
            'Simpanan Wajib' => 'Simpanan Wajib',
            'Simpanan Mana Suka' => 'Simpanan Mana Suka',

        ];
        $kredittransaksi = [
            'Simpanan Pokok' => 'Simpanan Pokok',
            'Simpanan Wajib' => 'Simpanan Wajib',
            'Simpanan Mana Suka' => 'Simpanan Mana Suka',
        ];
        $users = User::latest()->role('Anggota')->pluck('name', 'id')->all();
        $transaksis = $user->transaksis()->whereIn('jenis',['Simpanan Wajib','Simpanan Pokok','Simpanan Mana Suka'])->latest()->get();
        // dd($transaksis);

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
        return view('simpanan::admin.show', compact(['user', 'users', 'time', 'transaksis', 'debittransaksi', 'debittotal', 'kredittotal', 'kredittransaksi', 'kodetransaksi']))->with(['i' => 0]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('simpanan::edit');
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
