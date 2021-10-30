<?php

namespace Modules\User\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Anggota\Entities\Anggota;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'phone' => '089529909036',
            'password' => bcrypt('qweqwe')
        ]);
        $role = Role::create(['name' => 'Admin']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
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
        $role = Role::create(['name' => 'Pengawas']);
        $permissions = Permission::find(3);
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
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
        $role = Role::create(['name' => 'Anggota']);
        $permissions = Permission::find(2);
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
        Anggota::updateOrCreate([
            'kode' => '2021100001',
            'tipe' => 'PNS',
            'user_id' => $user->id,
        ]);

        $user = User::create([
            'name' => 'Cici',
            'email' => 'cici@gmail.com',
            'username' => 'cici',
            'phone' => '089512341234',
            'password' => bcrypt('qweqwe')
        ]);
        $user->assignRole([$role->id]);
        Anggota::updateOrCreate([
            'kode' => '2021100002',
            'tipe' => 'PNS',
            'user_id' => $user->id,
        ]);

        $user = User::create([
            'name' => 'Marwan',
            'email' => 'marwan@gmail.com',
            'username' => 'marwan',
            'phone' => '089512341234',
            'password' => bcrypt('qweqwe')
        ]);
        $user->assignRole([$role->id]);
        Anggota::updateOrCreate([
            'kode' => '2021100003',
            'tipe' => 'Honorer',
            'user_id' => $user->id,
        ]);

        $user = User::create([
            'name' => 'Nana',
            'email' => 'nana@gmail.com',
            'username' => 'nana',
            'phone' => '089512341234',
            'password' => bcrypt('qweqwe')
        ]);
        $user->assignRole([$role->id]);
        Anggota::updateOrCreate([
            'kode' => '2021100004',
            'tipe' => 'Honorer',
            'user_id' => $user->id,
        ]);
    }
}
