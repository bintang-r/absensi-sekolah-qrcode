<?php

namespace Database\Seeders;

use App\Models\ClassAttendance;
use App\Models\Student;
use App\Models\StudentAttendance;
use Faker\Factory;
use Illuminate\Database\Seeder;

class StudentAttendanceTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('id_ID');
        $classAttendances = ClassAttendance::all(['id','class_room_id']);
        $statusAttendance = config('const.attendance_status');

        foreach ($classAttendances as $classAttendance) {
            $students = Student::where('class_room_id', $classAttendance->class_room_id)->get(['id']);

            foreach ($students as $student) {
                $alreadyExists = StudentAttendance::where('class_attendance_id', $classAttendance->id)
                    ->where('student_id', $student->id)
                    ->exists();

                if (!$alreadyExists) {
                    StudentAttendance::create([
                        'class_attendance_id' => $classAttendance->id,
                        'student_id' => $student->id,
                        'status_attendance' => $faker->randomElement($statusAttendance),
                    ]);
                }
            }
        }
    }
}
