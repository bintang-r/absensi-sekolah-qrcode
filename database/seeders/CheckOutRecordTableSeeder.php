<?php

namespace Database\Seeders;

use App\Models\CheckOutRecord;
use App\Models\Student;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CheckOutRecordTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID');
        $studentIds = Student::pluck('id')->toArray();

        // 5 tahun terakhir (1x)
        foreach (range(1, 1) as $_) {
            $date = $faker->dateTimeBetween('-5 years', '-1 year');
            CheckOutRecord::create([
                'student_id'      => $faker->randomElement($studentIds),
                'check_in_time'   => $faker->dateTimeBetween($date->format('Y-m-d') . ' 06:00:00', $date->format('Y-m-d') . ' 09:00:00'),
                'attendance_date' => $date->format('Y-m-d'),
                'remarks'         => $faker->optional()->sentence,
            ]);
        }

        // 10 bulan terakhir (10x)
        foreach (range(1, 10) as $_) {
            $date = $faker->dateTimeBetween('-10 months', '-1 month');
            CheckOutRecord::create([
                'student_id'      => $faker->randomElement($studentIds),
                'check_in_time'   => $faker->dateTimeBetween($date->format('Y-m-d') . ' 06:00:00', $date->format('Y-m-d') . ' 09:00:00'),
                'attendance_date' => $date->format('Y-m-d'),
                'remarks'         => $faker->optional()->sentence,
            ]);
        }

        // 10 hari terakhir (10x)
        foreach (range(1, 10) as $_) {
            $date = $faker->dateTimeBetween('-10 days', '-1 day');
            CheckOutRecord::create([
                'student_id'      => $faker->randomElement($studentIds),
                'check_in_time'   => $faker->dateTimeBetween($date->format('Y-m-d') . ' 06:00:00', $date->format('Y-m-d') . ' 09:00:00'),
                'attendance_date' => $date->format('Y-m-d'),
                'remarks'         => $faker->optional()->sentence,
            ]);
        }

        // Hari ini (20x)
        foreach (range(1, 20) as $_) {
            $date = now();
            CheckOutRecord::create([
                'student_id'      => $faker->randomElement($studentIds),
                'check_in_time'   => $faker->dateTimeBetween($date->format('Y-m-d') . ' 06:00:00', $date->format('Y-m-d') . ' 09:00:00'),
                'attendance_date' => $date->format('Y-m-d'),
                'remarks'         => $faker->optional()->sentence,
            ]);
        }
    }
}
