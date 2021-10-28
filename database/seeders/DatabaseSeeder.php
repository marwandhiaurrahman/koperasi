<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Role\Database\Seeders\RoleDatabaseSeeder;
use Modules\User\Database\Seeders\UserDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleDatabaseSeeder::class,
            UserDatabaseSeeder::class,
        ]);
    }
}
