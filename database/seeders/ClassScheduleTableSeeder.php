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
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID');
        $classRooms = ClassRoom::all(['id','name_class']);
        $teacherIds = Teacher::pluck('id')->toArray();
        $subjectStudyIds = SubjectStudy::pluck('id')->toArray();

        // Assign subjects to teachers randomly (may repeat if teachers > subjects)
        $teacherSubjectMap = [];
        $shuffledSubjects = $subjectStudyIds;
        shuffle($shuffledSubjects);

        foreach ($teacherIds as $index => $teacherId) {
            $subjectStudyId = $shuffledSubjects[$index % count($shuffledSubjects)];
            Teacher::findOrFail($teacherId)->update([
                'subject_study_id' => $subjectStudyId,
            ]);
            $teacherSubjectMap[$teacherId] = $subjectStudyId;
        }

        $days = config('const.name_days');

        $timeSlots = [
            ['08:00:00', '09:30:00'],
            ['09:45:00', '11:15:00'],
            ['12:30:00', '14:00:00'],
            ['14:15:00', '15:45:00'],
        ];

        foreach($classRooms as $classRoom){

            // Shuffle teachers for each class
            $assignedTeachers = $faker->randomElements($teacherIds, min(count($teacherIds), 3));
            $usedSlots = [];
            foreach ($assignedTeachers as $teacherId) {
                $subjectStudyId = $teacherSubjectMap[$teacherId];

                // Each teacher teaches 1-2 times per class
                $teachCount = $faker->numberBetween(1, 2);
                for ($i = 0; $i < $teachCount; $i++) {

                    // Find a free slot (day + time) for this class and teacher
                    $availableSlots = [];
                    foreach ($days as $day) {
                        foreach ($timeSlots as $slot) {
                            $slotKey = $day . implode('-', $slot);
                            if (!isset($usedSlots[$slotKey])) {
                                $availableSlots[] = [
                                    'day' => $day,
                                    'start' => $slot[0],
                                    'end' => $slot[1],
                                    'key' => $slotKey,
                                ];
                            }
                        }
                    }

                    if (empty($availableSlots)) {
                        break; // No more available slots
                    }

                    $chosenSlot = $faker->randomElement($availableSlots);
                    $usedSlots[$chosenSlot['key']] = true;

                    ClassSchedule::create([
                        'class_room_id' => $classRoom->id,
                        'teacher_id' => $teacherId,
                        'subject_study_id' => $subjectStudyId,
                        'day_name' => $chosenSlot['day'],
                        'start_time' => $chosenSlot['start'],
                        'end_time' => $chosenSlot['end'],
                        'description' => $faker->sentence,
                    ]);
                }
            }
        }
    }
}
