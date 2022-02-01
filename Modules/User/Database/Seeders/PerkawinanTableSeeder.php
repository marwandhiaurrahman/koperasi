<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Perkawinan;

class PerkawinanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perkawinan = ['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'];
        foreach ($perkawinan as $value ) {
            Perkawinan::create(['name'=>$value]);
        }
    }
}
