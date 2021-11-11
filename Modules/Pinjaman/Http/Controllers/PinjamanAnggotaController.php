<?php

namespace Modules\Pinjaman\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Pinjaman\Entities\Pinjaman;
use Spatie\Permission\Models\Role;

class PinjamanAnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $time = Carbon::now();
        $kodetransaksi =  $time->year . $time->month . $time->day . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);

        $user = Auth::user();
        $users = Auth::user();
        $pinjamans = Pinjaman::where('anggota_id', $user->id)->latest()->get();
        $roles = Role::pluck('name', 'name')->all();

        $saldopinjaman = 0;
        $totalpinjaman = 0;
        foreach ($pinjamans as $value) {
            $saldopinjaman = $saldopinjaman + $value->saldo;
            $totalpinjaman = $totalpinjaman + $value->plafon;
        }

        $jenispinjaman = ['Bebas', 'Sebarkan'];
        return view('pinjaman::user.index', compact(['totalpinjaman','saldopinjaman', 'users', 'user', 'roles', 'pinjamans', 'kodetransaksi', 'jenispinjaman']))->with(['i' => 0]);
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
        //
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
