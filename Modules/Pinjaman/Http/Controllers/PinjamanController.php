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
use Modules\Transaksi\Http\Controllers\TransaksiController;
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

        $pinjamans = Pinjaman::with(['anggota', 'transaksis'])->paginate();

        $transaksis = Transaksi::with(['anggota', 'jenis_transaksi'])
            ->whereHas('jenis_transaksi', function ($query) {
                $query->where('group', 'pinjaman');
            })
            ->whereDate('created_at', '>=', $tanggal_awal)
            ->whereDate('created_at', '<=', $tanggal_akhir)
            ->orderByDesc('created_at')
            ->paginate();
        $anggotas = Anggota::with(['user', 'transaksis'])->latest()->get();
        $jenis_transaksis = JenisTransaksi::where('group', 'pinjaman')->pluck('name', 'kode')->toArray();
        return view('pinjaman::pinjaman_index', [
            'transaksis' => $transaksis,
            'request' => $request,
            'anggotas' => $anggotas,
            'jenis_transaksis' => $jenis_transaksis,
            'pinjamans' => $pinjamans,
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
        $time = Carbon::now();
        if (is_null($request->kode)) {
            $kodetransaksi = 'PJ' . $request->tipe . $time->year . str_pad($time->month, 2, '0', STR_PAD_LEFT) . str_pad($time->day, 2, '0', STR_PAD_LEFT)  . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);
            $request['kode'] = $kodetransaksi;
        }
        $request['admin_id'] = auth()->user()->id;
        $request['sisa_angsuran'] = $request->waktu;
        $request['saldo'] = $request->plafon + $request->jasa;

        $request->validate([
            'kode' => 'required|unique:pinjamen,kode,' . $request->id, //
            'tanggal' => 'required',
            'name' => 'required|unique:pinjamen,name,' . $request->id,
            'anggota_id' => 'required',
            'tipe' => 'required',
            'plafon' => 'required',
            'waktu' => 'required',
            'angsuran' => 'required',
            'jasa' => 'required',
            'saldo' => 'required', //
            'sisa_angsuran' => 'required', //
            'validasi' => 'required',
            'admin_id' => 'required', //
        ]);

        $pinjaman = Pinjaman::updateOrCreate(
            [
                'id' => $request->id,
                'kode' => $request->kode,
            ],
            [
                'name' => $request->name,
                'tanggal' => Carbon::parse($request->tanggal)->format('Y-m-d'),
                'anggota_id' => $request->anggota_id,
                'tipe' => $request->tipe,
                'plafon' => $request->plafon,
                'waktu' => $request->waktu,
                'angsuran' => $request->angsuran,
                'jasa' => $request->jasa,
                'saldo' => $request->saldo,
                'sisa_angsuran' => $request->sisa_angsuran,
                'validasi' => $request->validasi,
                'keterangan' => $request->keterangan,
                'admin_id' => auth()->user()->id,
            ]
        );

        $request['tanggal'] = $time;
        $request['anggota_id'] = $request->anggota_id;
        $request['jenis'] = $request->jenis;
        $request['tipe'] = 'Kredit';
        $request['nominal'] = $request->plafon + $request->jasa;
        $request['keterangan'] = $request->name;
        $request['validasi'] = 'Belum';

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
        $pinjaman->transaksis()->sync($transaksi->id);

        Alert::success('Success Info', 'Success Message');
        return redirect()->route('admin.pinjaman.index');
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

        // dd($pinjaman->anggota->user->name);
        // $anggota = Anggota::with(['user'])->findOrFail($id);
        // $transaksis = Transaksi::with(['anggota', 'jenis_transaksi'])
        //     ->whereHas('jenis_transaksi', function ($query) {
        //         $query->where('group', 'pinjaman');
        //     })
        //     // ->whereDate('created_at', '>=', $tanggal_awal)
        //     // ->whereDate('created_at', '<=', $tanggal_akhir)
        //     ->where('anggota_id', $id)
        //     ->orderByDesc('created_at')
        //     ->paginate();

        $jenis_transaksis = JenisTransaksi::where('group', 'angsuran')->pluck('name','kode')->toArray();
        return view('pinjaman::pinjaman_show', [
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
