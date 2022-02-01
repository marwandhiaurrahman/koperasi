<?php

namespace Modules\User\Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Anggota\Entities\Anggota;
use Modules\Transaksi\Entities\Transaksi;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Request $request)
    {
        $this->call([
            GenderTableSeeder::class,
            AgamaTableSeeder::class,
            PerkawinanTableSeeder::class,
        ]);

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'phone' => '089529909036',
            'password' => bcrypt('qweqwe')
        ]);
        $user->assignRole('Admin Super');
        Anggota::updateOrCreate([
            'kode' => '2021100000',
            'tipe' => 'PNS',
            'user_id' => $user->id,
        ]);
        $user = User::create([
            'name' => 'Pengawas',
            'email' => 'pengawas@gmail.com',
            'username' => 'pengawas',
            'phone' => '089529909036',
            'password' => bcrypt('qweqwe')
        ]);
        $user->assignRole('Pengawas');
        Anggota::updateOrCreate([
            'kode' => '2021100010',
            'tipe' => 'PNS',
            'user_id' => $user->id,
        ]);
        $user = User::create([
            'name' => 'Anggota',
            'email' => 'anggota@gmail.com',
            'username' => 'anggota',
            'phone' => '089512341234',
            'password' => bcrypt('qweqwe')
        ]);
        $user->assignRole('Anggota');
        Anggota::updateOrCreate([
            'kode' => '2021100001',
            'tipe' => 'PNS',
            'user_id' => $user->id,
        ]);
        $time = Carbon::now();
        $kodetransaksi =  $time->year . $time->month . $time->day . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);
        $request['kode'] = $kodetransaksi;
        $request['tanggal'] = $time;
        $request['anggota_id'] = $user->id;
        $request['jenis'] = 'SP';
        $request['tipe'] = 'Debit';
        $request['nominal'] = '100000';
        $request['validasi'] = 'Belum';
        $request['keterangan'] = 'Biaya Pendaftaran';
        $request->validate([
            'kode' => 'required|unique:transaksis',
            'tanggal' => 'required|date',
            'anggota_id' => 'required',
            'jenis' => 'required',
            'tipe' => 'required',
            'nominal' => 'required',
            'validasi' => 'required',
            'keterangan' => 'required',
        ]);
        Transaksi::updateOrCreate([
            'kode' => $request->kode,
            'tanggal' => $request->tanggal,
            'anggota_id' => $request->anggota_id,
            'jenis' => $request->jenis,
            'tipe' => $request->tipe,
            'nominal' => $request->nominal,
            'validasi' => $request->validasi,
            'keterangan' => $request->keterangan,
        ]);

        // $user = User::create([
        //     'name' => 'Cici',
        //     'email' => 'cici@gmail.com',
        //     'username' => 'cici',
        //     'phone' => '089512341234',
        //     'password' => bcrypt('qweqwe')
        // ]);
        // $user->assignRole([$role->id]);
        // Anggota::updateOrCreate([
        //     'kode' => '2021100002',
        //     'tipe' => 'PNS',
        //     'user_id' => $user->id,
        // ]);
        // $time = Carbon::now();
        // $kodetransaksi =  $time->year . $time->month . $time->day . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);
        // $request['kode'] = $kodetransaksi;
        // $request['tanggal'] = $time;
        // $request['anggota_id'] = $user->id;
        // $request['jenis'] = 'Simpanan Pokok';
        // $request['tipe'] = 'Debit';
        // $request['nominal'] = '100000';
        // $request['validasi'] = 0;
        // $request['keterangan'] = 'Biaya Pendaftaran';
        // $request->validate([
        //     'kode' => 'required|unique:transaksis',
        //     'tanggal' => 'required|date',
        //     'anggota_id' => 'required',
        //     'jenis' => 'required',
        //     'tipe' => 'required',
        //     'nominal' => 'required',
        //     'validasi' => 'required',
        //     'keterangan' => 'required',
        // ]);

        // if ($request->tipe == "Kredit") {
        //     $request->nominal = -1 * $request->nominal;
        // }
        // Transaksi::updateOrCreate([
        //     'kode' => $request->kode,
        //     'tanggal' => $request->tanggal,
        //     'anggota_id' => $request->anggota_id,
        //     'jenis' => $request->jenis,
        //     'tipe' => $request->tipe,
        //     'nominal' => $request->nominal,
        //     'validasi' => $request->validasi,
        //     'keterangan' => $request->keterangan,
        // ]);

        // $user = User::create([
        //     'name' => 'Marwan',
        //     'email' => 'marwan@gmail.com',
        //     'username' => 'marwan',
        //     'phone' => '089512341234',
        //     'password' => bcrypt('qweqwe')
        // ]);
        // $user->assignRole([$role->id]);
        // Anggota::updateOrCreate([
        //     'kode' => '2021100003',
        //     'tipe' => 'Honorer',
        //     'user_id' => $user->id,
        // ]);
        // $time = Carbon::now();
        // $kodetransaksi =  $time->year . $time->month . $time->day . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);
        // $request['kode'] = $kodetransaksi;
        // $request['tanggal'] = $time;
        // $request['anggota_id'] = $user->id;
        // $request['jenis'] = 'Simpanan Pokok';
        // $request['tipe'] = 'Debit';
        // $request['nominal'] = '100000';
        // $request['validasi'] = 0;
        // $request['keterangan'] = 'Biaya Pendaftaran';
        // $request->validate([
        //     'kode' => 'required|unique:transaksis',
        //     'tanggal' => 'required|date',
        //     'anggota_id' => 'required',
        //     'jenis' => 'required',
        //     'tipe' => 'required',
        //     'nominal' => 'required',
        //     'validasi' => 'required',
        //     'keterangan' => 'required',
        // ]);

        // if ($request->tipe == "Kredit") {
        //     $request->nominal = -1 * $request->nominal;
        // }
        // Transaksi::updateOrCreate([
        //     'kode' => $request->kode,
        //     'tanggal' => $request->tanggal,
        //     'anggota_id' => $request->anggota_id,
        //     'jenis' => $request->jenis,
        //     'tipe' => $request->tipe,
        //     'nominal' => $request->nominal,
        //     'validasi' => $request->validasi,
        //     'keterangan' => $request->keterangan,
        // ]);

        // $user = User::create([
        //     'name' => 'Nana',
        //     'email' => 'nana@gmail.com',
        //     'username' => 'nana',
        //     'phone' => '089512341234',
        //     'password' => bcrypt('qweqwe')
        // ]);
        // $user->assignRole([$role->id]);
        // Anggota::updateOrCreate([
        //     'kode' => '2021100004',
        //     'tipe' => 'Honorer',
        //     'user_id' => $user->id,
        // ]);
        // $time = Carbon::now();
        // $kodetransaksi =  $time->year . $time->month . $time->day . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);
        // $request['kode'] = $kodetransaksi;
        // $request['tanggal'] = $time;
        // $request['anggota_id'] = $user->id;
        // $request['jenis'] = 'Simpanan Pokok';
        // $request['tipe'] = 'Debit';
        // $request['nominal'] = '100000';
        // $request['validasi'] = 0;
        // $request['keterangan'] = 'Biaya Pendaftaran';
        // $request->validate([
        //     'kode' => 'required|unique:transaksis',
        //     'tanggal' => 'required|date',
        //     'anggota_id' => 'required',
        //     'jenis' => 'required',
        //     'tipe' => 'required',
        //     'nominal' => 'required',
        //     'validasi' => 'required',
        //     'keterangan' => 'required',
        // ]);

        // if ($request->tipe == "Kredit") {
        //     $request->nominal = -1 * $request->nominal;
        // }
        // Transaksi::updateOrCreate([
        //     'kode' => $request->kode,
        //     'tanggal' => $request->tanggal,
        //     'anggota_id' => $request->anggota_id,
        //     'jenis' => $request->jenis,
        //     'tipe' => $request->tipe,
        //     'nominal' => $request->nominal,
        //     'validasi' => $request->validasi,
        //     'keterangan' => $request->keterangan,
        // ]);
    }
}
