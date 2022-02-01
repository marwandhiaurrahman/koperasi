<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Agama;

class AgamaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $agamas = ['Islam', 'Kristen', 'Katolik', 'Budha', 'Hindu', 'Konghuchu', 'Kepercayaan Lainnya'];
        foreach ($agamas as $value) {
            Agama::create(['name' => $value]);
        }
    }
}
