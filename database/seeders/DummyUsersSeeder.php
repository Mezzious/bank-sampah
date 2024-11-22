<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userData = [
            [
                'name' => 'Superadmin',
                'email' => 'superadmin@gmail.com',
                'roles' => 'super-admin',
                'password' => bcrypt('Superadmin123!')
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'roles' => 'admin',
                'password' => bcrypt('Admin123!')
            ],
            [
                'name' => 'Pengepul',
                'email' => 'pengepul@gmail.com',
                'roles' => 'user',
                'password' => bcrypt('Pengepul123!')
            ],
        ];

        foreach ($userData as $key => $val) {
            User::create($val);
        }
    }
}
