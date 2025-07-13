<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'Bintang Admin',
                'email' => 'muhbintang650@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('bintang123'),
                'role' => 'admin',
            ],
            [
                'username' => 'Supriadi',
                'email' => 'supriadi@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('supriadi123'),
                'role' => 'admin',
            ],
            [
                'username' => 'Ardiansyah',
                'email' => 'ardiansyah@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('ardiansyah123'),
                'role' => 'admin',
            ],
        ];

        foreach($users as $user){
            User::create($user);
        }
    }
}

