<?php

namespace Modules\Transaksi\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Anggota\Entities\Anggota;
use Modules\Transaksi\Entities\JenisTransaksi;
use Modules\Transaksi\Entities\Transaksi;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;

class TransaksiController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admin|pengawas', ['only' => ['index']]);
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
        $transaksis = Transaksi::whereDate('created_at', '>=', $tanggal_awal)
            ->whereDate('created_at', '<=', $tanggal_akhir)
            ->orderByDesc('created_at')
            ->paginate();
        $nominal_debit = Transaksi::whereDate('created_at', '>=', $tanggal_awal)
            ->whereDate('created_at', '<=', $tanggal_akhir)
            ->where('tipe', 'Debit')
            ->sum('nominal');
        $nominal_kredit = Transaksi::whereDate('created_at', '>=', $tanggal_awal)
            ->whereDate('created_at', '<=', $tanggal_akhir)
            ->where('tipe', 'Kredit')
            ->sum('nominal');
        $anggotas = User::latest()->role('Anggota')->pluck('name', 'id')->toArray();
        $jenis_transaksis = JenisTransaksi::pluck('name', 'kode')->toArray();
        return view('transaksi::transaksi_index', [
            'transaksis' => $transaksis,
            'request' => $request,
            'anggotas' => $anggotas,
            'nominal_debit' => $nominal_debit,
            'nominal_kredit' => $nominal_kredit,
            'jenis_transaksis' => $jenis_transaksis,
            'i' => (request()->input('page', 1) - 1) * $transaksis->perPage()
        ]);
    }
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

        Alert::success('Success Info', 'Success Message');
        return redirect()->route('admin.transaksi.index');
    }
    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $anggotas = User::latest()->role('Anggota')->pluck('name', 'id')->toArray();
        $jenis_transaksis = JenisTransaksi::pluck('name', 'kode')->toArray();
        return view('transaksi::transaksi_edit', [
            'transaksi' => $transaksi,
            'anggotas' => $anggotas,
            'jenis_transaksis' => $jenis_transaksis,
        ]);
    }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'validasi' => 'required',
    //         'admin_id' => 'required',
    //     ]);

    //     $transaksi = Transaksi::find($id);
    //     $transaksi->update(
    //         [
    //             'validasi' => $request->validasi,
    //             'admin_id' => $request->admin_id,
    //         ]
    //     );

    //     Alert::success('Success Info', 'Success Message');
    //     return redirect()->route('admin.transaksi.index');
    // }

    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->delete();
        Alert::success('Success Info', 'Transaksi Berhasil Dihapus');
        return redirect()->route('admin.transaksi.index');
    }
}
