<?php

namespace Modules\Pinjaman\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pinjaman\Entities\Pinjaman;
use Modules\Transaksi\Entities\Transaksi;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;

class PinjamanController extends Controller
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
        $time = Carbon::now();
        $kodetransaksi =  $time->year . $time->month . $time->day . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);

        $users = User::role('Anggota')->get();
        $pinjamans = Pinjaman::latest()->get();
        $roles = Role::pluck('name', 'name')->all();

        $jenispinjaman = ['Bebas', 'Sebarkan'];
        return view('pinjaman::admin.index', compact(['users', 'roles', 'pinjamans', 'kodetransaksi', 'jenispinjaman']))->with(['i' => 0]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('pinjaman::create');
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
            'waktu' => 'required',
            'plafon' => 'required',
            'validasi' => 'required',
            'keterangan' => 'required',
            'user_id' => 'required',
        ]);

        $request['tipe'] = 'Kredit';
        if ($request->tipe == "Kredit") {
            $request['nominal'] = -1 * ($request->plafon + $request->jasa);
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
        return redirect()->route('admin.pinjaman.index')->with('success', 'Pinjaman Sudah Dibuat');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('pinjaman::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('pinjaman::edit');
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
