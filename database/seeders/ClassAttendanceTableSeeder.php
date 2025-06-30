<?php

namespace Database\Seeders;

use App\Models\ClassAttendance;
use App\Models\ClassSchedule;
use App\Models\Student;
use App\Models\StudentAttendance;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ClassAttendanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        // Ambil semua jadwal beserta guru dan kelasnya dalam satu query
        $schedules = ClassSchedule::with(['teacher:id', 'class_room:id'])->get(['id', 'teacher_id', 'class_room_id']);

        // Kelompokkan jadwal berdasarkan guru
        $schedulesByTeacher = $schedules->groupBy('teacher_id');

        foreach ($schedulesByTeacher as $teacherId => $teacherSchedules) {
            $classRoomIds = $teacherSchedules->pluck('class_room_id')->unique()->values()->all();
            $scheduleIds = $teacherSchedules->pluck('id')->all();

            foreach($classRoomIds as $classRoomId){
                $classAttendance = ClassAttendance::create([
                    'class_room_id' => $classRoomId,
                    'class_schedule_id' => $faker->randomElement($scheduleIds),
                    'explanation_material' => $faker->sentence(),
                    'name_material' => $faker->sentence(),
                    'created_at' => $faker->dateTimeBetween('-1 month', 'now'),
                    'updated_at' => $faker->dateTimeBetween('-1 month', 'now'),
                ]);

                $students = Student::where('class_room_id', $classRoomId)->get(['id','call_name']);

                foreach($students as $student){
                    $attendanceStatus = $faker->randomElement(config('const.attendance_status'));
                    StudentAttendance::create([
                        'class_attendance_id' => $classAttendance->id,
                        'student_id' => $student->id,
                        'status_attendance' => $attendanceStatus,
                    ]);
                }
            }
        }
    }
}
