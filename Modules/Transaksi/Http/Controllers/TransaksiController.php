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

        $nominal_transaksi = Transaksi::whereDate('created_at', '>=', $tanggal_awal)
            ->whereDate('created_at', '<=', $tanggal_akhir)
            ->groupBy('tipe')
            ->selectRaw('tipe, sum(nominal) as nominal')
            ->get();

        return view('transaksi::transaksi_index', [
            'transaksis' => $transaksis,
            'request' => $request,
            'nominal_transaksi' => $nominal_transaksi,
            'i' => ($request->input('page', 1) - 1) * $transaksis->perPage(),
        ]);

        dd($transaksis);

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
        return view('transaksi::admin.index', compact(['users', 'time', 'transaksis', 'debittransaksi', 'debittotal', 'kredittotal', 'kredittransaksi', 'kodetransaksi']))->with(['i' => 0]);
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

        Alert::success('Success Info', 'Success Message');
        return redirect()->route('admin.transaksi.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $transaksi = Transaksi::find($id);
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
        return view('transaksi::admin.show', compact(['transaksi', 'debittransaksi']));
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
        $request->validate([
            'validasi' => 'required',
            'user_id' => 'required',
        ]);

        $transaksi = Transaksi::find($id);
        $transaksi->update(
            [
                'validasi' => $request->validasi,
                'user_id' => $request->user_id,
            ]
        );

        Alert::success('Success Info', 'Success Message');
        return redirect()->route('admin.transaksi.index');
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
