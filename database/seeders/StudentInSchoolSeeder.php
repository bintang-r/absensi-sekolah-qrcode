<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentInSchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::all(['id', 'full_name']);
        $toggle = true;

        foreach ($students as $student) {
            $student->update([
                'in_school' => $toggle,
            ]);

            $toggle = !$toggle;
        }
    }
}
