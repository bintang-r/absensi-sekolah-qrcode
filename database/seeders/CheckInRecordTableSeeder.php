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

        // 5 tahun terakhir (selain 10 bulan & 10 hari terakhir)
        foreach (range(1, 100) as $_) {
            $date = $faker->dateTimeBetween('-5 years', '-10 months');
            CheckInRecord::create([
                'student_id'      => $faker->randomElement($studentIds),
                'check_in_time'   => $faker->dateTimeBetween($date->format('Y-m-d') . ' 06:00:00', $date->format('Y-m-d') . ' 09:00:00'),
                'attendance_date' => $date->format('Y-m-d'),
                'remarks'         => $faker->optional()->sentence,
            ]);
        }

        // 10 bulan terakhir (selain 10 hari terakhir)
        foreach (range(1, 50) as $_) {
            $date = $faker->dateTimeBetween('-10 months', '-10 days');
            CheckInRecord::create([
                'student_id'      => $faker->randomElement($studentIds),
                'check_in_time'   => $faker->dateTimeBetween($date->format('Y-m-d') . ' 06:00:00', $date->format('Y-m-d') . ' 09:00:00'),
                'attendance_date' => $date->format('Y-m-d'),
                'remarks'         => $faker->optional()->sentence,
            ]);
        }

        // 10 hari terakhir (selain hari ini)
        foreach (range(1, 30) as $_) {
            $date = $faker->dateTimeBetween('-10 days', 'yesterday');
            CheckInRecord::create([
                'student_id'      => $faker->randomElement($studentIds),
                'check_in_time'   => $faker->dateTimeBetween($date->format('Y-m-d') . ' 06:00:00', $date->format('Y-m-d') . ' 09:00:00'),
                'attendance_date' => $date->format('Y-m-d'),
                'remarks'         => $faker->optional()->sentence,
            ]);
        }

        // Hari ini (20 data)
        $today = now()->format('Y-m-d');
        foreach (range(1, 20) as $_) {
            CheckInRecord::create([
                'student_id'      => $faker->randomElement($studentIds),
                'check_in_time'   => $faker->dateTimeBetween($today . ' 06:00:00', $today . ' 09:00:00'),
                'attendance_date' => $today,
                'remarks'         => $faker->optional()->sentence,
            ]);
        }
    }
}
