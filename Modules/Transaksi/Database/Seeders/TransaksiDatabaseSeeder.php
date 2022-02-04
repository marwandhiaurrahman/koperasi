<?php

namespace Modules\Transaksi\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Transaksi\Entities\JenisTransaksi;

class TransaksiDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenis_transaksi = [
            [
                'kode' => 'SP',
                'name' => 'Simpanan Pokok',
                'status' => '0',
                'group' => 'simpanan',
            ],
            [
                'kode' => 'SW',
                'name' => 'Simpanan Wajib',
                'status' => '0',
                'group' => 'simpanan',
            ],
            [
                'kode' => 'SS',
                'name' => 'Simpanan Sukarela',
                'status' => '0',
                'group' => 'simpanan',
            ],
            [
                'kode' => 'RAYA',
                'name' => 'Simpanan Hari Raya',
                'status' => '0',
                'group' => 'simpanan',
            ],
            [
                'kode' => 'PJN',
                'name' => 'Pinjaman Normal',
                'status' => '0',
                'group' => 'pinjaman',
            ],
            [
                'kode' => 'PJK',
                'name' => 'Pinjaman Khusus',
                'status' => '0',
                'group' => 'pinjaman',
            ],
            [
                'kode' => 'AGS',
                'name' => 'Angsuran',
                'status' => '0',
                'group' => 'angsuran',
            ],
            [
                'kode' => 'JS',
                'name' => 'Jasa',
                'status' => '0',
                'group' => 'jasa',
            ],
            [
                'kode' => 'LAIN',
                'name' => 'Lainnya',
                'status' => '0',
                'group' => 'lainnya',
            ],
        ];
        foreach ($jenis_transaksi as $value) {
            JenisTransaksi::updateOrCreate(['kode' => $value['kode']], $value);
        }
    }
}
