<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $religions = config('const.religions');

        $i = 1;
        $limit = 50;
        $students = [];
        $users = [];
        while(true){
            $sex = $faker->randomElement(config('const.sex'));
            $name = $faker->name($sex == 'laki-laki' ? 'male' : 'female');
            $callName = strtolower(explode(' ', trim($name))[0]);

            $users[] = [
                'username' => $name,
                'email'    => $callName . rand($i, $i * (1-$i)) . '@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('student123'),
                'role'     => 'siswa',
            ];

            $students[] = [
                'full_name'      => $name,
                'call_name'      => $callName,
                'sex'            => $sex,
                'nis'            => $faker->unique()->numerify('19########'),
                'phone'          => $faker->phoneNumber,
                'religion'       => $faker->randomElement($religions),
                'origin_school'  => $faker->company . ' School',
                'birth_date'     => $faker->date('Y-m-d', '-25 years'),
                'place_of_birth' => $faker->city,
                'address'        => $faker->address,
                'postal_code'    => $faker->postcode,
                'admission_year' => $faker->year('-10 years'),
                'father_name'    => $faker->name('male'),
                'mother_name'    => $faker->name('female'),
                'father_job'     => $faker->jobTitle,
                'mother_job'     => $faker->jobTitle,
            ];

            $i++;

            if($i >= $limit){
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
            $students[$j]['user_id'] = $userIds[$j];

            $j++;

            if($j >= count($students)) {
                break;
            }
        }

        DB::table('students')->insert($students);
    }
}
