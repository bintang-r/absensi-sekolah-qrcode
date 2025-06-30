<?php

namespace Database\Seeders;

use App\Models\CheckInRecord;
use App\Models\Student;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CheckInRecordTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID');
        $studentIds = Student::pluck('id')->toArray();

        foreach (range(1, 200) as $_) {
            $date = $faker->dateTimeBetween('-1 month', 'now');

            CheckInRecord::create([
                'student_id'      => $faker->randomElement($studentIds),
                'check_in_time'   => $faker->dateTimeBetween($date->format('Y-m-d') . ' 06:00:00', $date->format('Y-m-d') . ' 09:00:00'),
                'attendance_date' => $date->format('Y-m-d'),
                'remarks'         => $faker->optional()->sentence,
            ]);
        }
    }
}
