<?php

namespace Modules\Simpanan\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Simpanan\Entities\JenisSimpanan;

class SimpananDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenis_simpanan = [
            [
                'name' => 'Simpanan Pokok',
                'kode' => 'SP',
                'status' => '0',
            ],
            [
                'name' => 'Simpanan Wajib',
                'kode' => 'SW',
                'status' => '0',
            ],
            [
                'name' => 'Simpanan Sukarela',
                'kode' => 'SS',
                'status' => '0',
            ],
            [
                'name' => 'Simpanan Hari Raya',
                'kode' => 'RAYA',
                'status' => '0',
            ],
        ];
        foreach ($jenis_simpanan as $value) {
            JenisSimpanan::updateOrCreate(['kode' => $value['kode']], $value);
        }
    }
}
