<?php

namespace Modules\Simpanan\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Anggota\Entities\Anggota;
use Modules\Transaksi\Entities\Transaksi;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;

class SimpananController extends Controller
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
                $query->where('group', 'simpanan');
            })
            ->whereDate('created_at', '>=', $tanggal_awal)
            ->whereDate('created_at', '<=', $tanggal_akhir)
            ->orderByDesc('created_at')
            ->paginate();

        $anggotas = Anggota::with(['user', 'transaksis'])->latest()->get();


        // dd($anggotas->first()->user->name, $anggotas->first()->transaksis->first());

        return view('simpanan::simpanan_index', [
            'transaksis' => $transaksis,
            'request' => $request,
            'anggotas' => $anggotas,
            'i' => (request()->input('page', 1) - 1) * $transaksis->perPage()
        ]);
    }
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
        return redirect()->route('admin.simpanan.show', compact('simpanan'));
    }

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
        $transaksis = $user->transaksis()->whereIn('jenis', ['Simpanan Wajib', 'Simpanan Pokok', 'Simpanan Mana Suka'])->latest()->get();
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

    public function edit($id)
    {
        return view('simpanan::edit');
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
