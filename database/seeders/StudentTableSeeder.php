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
        $students = [];
        while(true){
            $sex = $faker->randomElement(config('const.sex'));
            $name = $faker->name($sex == 'laki-laki' ? 'male' : 'female');
            $callName = strtolower(explode(' ', trim($name))[0]);

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

            if($i >= 50){
                break;
            }
        }

        DB::table('students')->insert($students);
    }
}
