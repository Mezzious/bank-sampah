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
                'name' => 'Epin',
                'email' => 'calvin@gmail.com',
                'role' => 'super-admin',
                'password' => bcrypt('123456')
            ],
            [
                'name' => 'Fadhil',
                'email' => 'fadhil@gmail.com',
                'role' => 'admin',
                'password' => bcrypt('123456')
            ],
            [
                'name' => 'Reny',
                'email' => 'reny@gmail.com',
                'role' => 'user',
                'password' => bcrypt('123456')
            ],
        ];

        foreach ($userData as $key => $val) {
            User::create($val);
        }
    }
}
