<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\ClassSchedule;
use App\Models\SubjectStudy;
use App\Models\Teacher;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ClassScheduleTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('id_ID');
        $classRooms = ClassRoom::pluck('id')->toArray();
        $teachers = Teacher::all();
        $subjectStudyIds = SubjectStudy::pluck('id')->toArray();
        $days = config('const.name_days');

        $timeSlots = [
            ['08:00:00', '09:30:00'],
            ['09:45:00', '11:15:00'],
            ['12:30:00', '14:00:00'],
            ['14:15:00', '15:45:00'],
        ];

        // Menyimpan slot yang sudah dipakai agar tidak bentrok
        $usedSlots = [];

        foreach ($teachers as $teacher) {
            // Assign random subject to teacher (jika belum ada kolom relasi subject di model Teacher, ini opsional)
            $subjectStudyId = $faker->randomElement($subjectStudyIds);
            $teacher->update(['subject_study_id' => $subjectStudyId]);

            // Tentukan berapa kali guru ini akan mengajar
            $teachCount = $faker->numberBetween(1, 3);

            for ($i = 0; $i < $teachCount; $i++) {
                $availableSlots = [];

                foreach ($days as $day) {
                    foreach ($timeSlots as $slot) {
                        foreach ($classRooms as $classRoomId) {
                            $slotKey = "{$classRoomId}_{$day}_{$slot[0]}_{$slot[1]}";

                            if (!isset($usedSlots[$slotKey])) {
                                $availableSlots[] = [
                                    'day' => $day,
                                    'start' => $slot[0],
                                    'end' => $slot[1],
                                    'class_room_id' => $classRoomId,
                                    'key' => $slotKey,
                                ];
                            }
                        }
                    }
                }

                if (empty($availableSlots)) {
                    break; // Tidak ada slot tersedia
                }

                $chosen = $faker->randomElement($availableSlots);
                $usedSlots[$chosen['key']] = true;

                ClassSchedule::create([
                    'class_room_id' => $chosen['class_room_id'],
                    'teacher_id' => $teacher->id,
                    'subject_study_id' => $subjectStudyId,
                    'day_name' => $chosen['day'],
                    'start_time' => $chosen['start'],
                    'end_time' => $chosen['end'],
                    'description' => $faker->sentence,
                ]);
            }
        }
    }
}
