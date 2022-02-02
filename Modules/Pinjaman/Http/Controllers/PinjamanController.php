<?php

namespace Modules\Pinjaman\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Anggota\Entities\Anggota;
use Modules\Pinjaman\Entities\Pinjaman;
use Modules\Transaksi\Entities\JenisTransaksi;
use Modules\Transaksi\Entities\Transaksi;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;

class PinjamanController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admin|pengawas', ['only' => ['index', 'show']]);
        $this->middleware('permission:admin', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }
    public function index(Request $request)
    {
        if (is_null($request->periode)) {
            $request['periode'] = Carbon::today()->format('d-m-Y') . ' - ' . Carbon::today()->format('d-m-Y');
        }
        $tanggal = explode(' - ', $request->periode);
        $tanggal_awal = Carbon::parse($tanggal[0])->startOfDay();
        $tanggal_akhir = Carbon::parse($tanggal[1])->endOfDay();
        $transaksis = Transaksi::with(['anggota', 'jenis_transaksi'])
            ->whereHas('jenis_transaksi', function ($query) {
                $query->where('group', 'pinjaman');
            })
            ->whereDate('created_at', '>=', $tanggal_awal)
            ->whereDate('created_at', '<=', $tanggal_akhir)
            ->orderByDesc('created_at')
            ->paginate();
        $anggotas = Anggota::with(['user', 'transaksis'])->latest()->get();
        return view('pinjaman::pinjaman_index', [
            'transaksis' => $transaksis,
            'request' => $request,
            'anggotas' => $anggotas,
            'i' => (request()->input('page', 1) - 1) * $transaksis->perPage()
        ]);

        // $time = Carbon::now();
        // $kodetransaksi =  $time->year . $time->month . $time->day . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);

        // $users = User::role('Anggota')->get();
        // $pinjamans = Pinjaman::latest()->get();
        // $roles = Role::pluck('name', 'name')->all();

        // $jenispinjaman = ['Bebas', 'Sebarkan'];
        // return view('pinjaman::admin.index', compact(['users', 'roles', 'pinjamans', 'kodetransaksi', 'jenispinjaman']))->with(['i' => 0]);
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
            'user_id' => 'required',
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
        return redirect()->route('admin.pinjaman.index')->with('success', 'Pinjaman Sudah Dibuat');
    }

    public function show($id, Request $request)
    {
        if (is_null($request->periode)) {
            $request['periode'] = Carbon::today()->format('d-m-Y') . ' - ' . Carbon::today()->format('d-m-Y');
        }
        $tanggal = explode(' - ', $request->periode);
        $tanggal_awal = Carbon::parse($tanggal[0])->startOfDay();
        $tanggal_akhir = Carbon::parse($tanggal[1])->endOfDay();

        $anggota = Anggota::with(['user'])->findOrFail($id);

        $transaksis = Transaksi::with(['anggota', 'jenis_transaksi'])
            ->whereHas('jenis_transaksi', function ($query) {
                $query->where('group', 'pinjaman');
            })
            // ->whereDate('created_at', '>=', $tanggal_awal)
            // ->whereDate('created_at', '<=', $tanggal_akhir)
            ->where('anggota_id', $id)
            ->orderByDesc('created_at')
            ->paginate();

        $jenis_simpanan = JenisTransaksi::where('group', 'pinjaman')->get();

        return view('simpanan::simpanan_show', [
            'transaksis' => $transaksis,
            'request' => $request,
            'anggota' => $anggota,
            'jenis_simpanan' => $jenis_simpanan,
            'i' => (request()->input('page', 1) - 1) * $transaksis->perPage()
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
