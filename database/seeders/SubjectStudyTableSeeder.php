<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectStudyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID');
        $subjectStudies = [];

        $subjects = [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Ilmu Pengetahuan Alam',
            'Ilmu Pengetahuan Sosial',
            'Pendidikan Kewarganegaraan',
            'Pendidikan Agama',
            'Seni Budaya',
            'Pendidikan Jasmani',
            'Fisika',
            'Kimia',
            'Biologi',
            'Ekonomi',
            'Geografi',
            'Sejarah',
            'Sosiologi',
            'Teknologi Informasi',
            'Prakarya',
            'Bimbingan Konseling',
            'Kewirausahaan'
        ];

        $i = 0;
        while (true) {
            $subjectStudies[] = [
                'name_subject' => $subjects[$i],
                'description' => $subjects[$i] . ", dengan pertemuan 2 semester.",
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
