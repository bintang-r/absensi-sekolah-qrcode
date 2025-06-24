<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectStudyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $subjects = config('const.subject_study_examples');

        $i = 0;
        $subjectStudies = [];
        while (true) {
            $subjectStudies[] = [
                'name_subject'  => $subjects[$i],
                'description'   => $subjects[$i] . ", dengan pertemuan 2 semester.",
                'status_active' => $faker->boolean(80),
            ];

            $i++;

            if (($i + 1) >= count($subjects)) {
                break;
            }
        }

        DB::table('subject_studies')->insert($subjectStudies);
    }
}
