<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $religions = config('const.religions');
        $sex = config('const.sex');

        $limit = 50;
        $i = 1;
        $teachers = [];
        $users = [];
        while (true) {
            $sexValue = $faker->randomElement($sex);
            $name = $faker->name($sexValue == 'laki-laki' ? 'male' : 'female');
            $username = strtolower(str_replace(' ', '_', $name));

            $users[] = [
                'username'          => $username,
                'email'             => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password'          => bcrypt('teacher123'),
                'role'              => 'teacher',
            ];

            $teachers[] = [
                'name'              => $name,
                'sex'               => $sexValue,
                'nip'               => $faker->unique()->numerify('19###########'),
                'nuptk'             => $faker->unique()->numerify('##########'),
                'phone'             => $faker->phoneNumber,
                'religion'          => $faker->randomElement($religions),
                'birth_date'        => $faker->date('Y-m-d', '-25 years'),
                'place_of_birth'    => $faker->city,
                'address'           => $faker->address,
                'postal_code'       => $faker->postcode,
                'date_joined'       => $faker->date('Y-m-d', '-5 years'),
            ];

            $i++;

            if ($i > $limit) {
                break;
            }
        }

        DB::table('users')->insert($users);

        $userIds = DB::table('users')
            ->orderBy('id', 'desc')
            ->take($limit)->pluck('id')
            ->reverse()
            ->values();

        $j = 0;
        while(true){
            $teachers[$j]['user_id'] = $userIds[$j];

            $j++;

            if($j >= count($teachers)) {
                break;
            }
        }

        DB::table('teachers')->insert($teachers);
    }
}
