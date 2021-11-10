<?php

namespace Modules\Pinjaman\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;

class PinjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    function __construct()
    {
        $this->middleware('permission:admin-role|pengawas-role', ['only' => ['index','show']]);
        $this->middleware('permission:admin-role', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }
    public function index()
    {
        $time = Carbon::now();
        $kodetransaksi =  $time->year . $time->month . $time->day . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);

        $users = User::role('Anggota')->get();
        $roles = Role::pluck('name', 'name')->all();

        $jenispinjaman=['Bebas','Sebarkan'];
        return view('pinjaman::admin.index', compact(['users', 'roles','kodetransaksi','jenispinjaman']))->with(['i' => 0]);
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
