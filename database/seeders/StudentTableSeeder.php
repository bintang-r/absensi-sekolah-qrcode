<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $religions = config('const.religions');
        $classRoomIds = ClassRoom::pluck('id')->toArray();

        // Path ke file example
        $exampleLatarMerahCewek = public_path('static/ryoogen/example/latar-merah-cewek.jpg');
        $exampleLatarMerahCowok = public_path('static/ryoogen/example/latar-merah-cowok.jpeg');

        $students = [];
        $users = [];

        // Pastikan direktori storage/student-photos ada
        $storagePath = storage_path('app/public/student-photos');
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        $i = 1;
        foreach ($classRoomIds as $classRoomId) {
            for ($j = 0; $j < 30; $j++) {
                $sex = $faker->randomElement(config('const.sex'));
                $name = $faker->name($sex == 'laki-laki' ? 'male' : 'female');
                $callName = strtolower(explode(' ', trim($name))[0]);

                $users[] = [
                    'username' => $callName . $i,
                    'email'    => $callName . $i . '@example.com',
                    'email_verified_at' => now(),
                    'password' => bcrypt('student123'),
                    'role'     => 'siswa',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Tentukan file foto berdasarkan jenis kelamin
                if ($sex == 'laki-laki') {
                    $sourcePhoto = $exampleLatarMerahCowok;
                    $extension = '.jpeg';
                } else {
                    $sourcePhoto = $exampleLatarMerahCewek;
                    $extension = '.jpg';
                }

                $photoFileName = 'student_' . $i . '_' . time() . $extension;
                $destinationRelativePath = 'student-photos/' . $photoFileName;
                $destinationFullPath = $storagePath . '/' . $photoFileName;

                // Copy file ke storage/student-photos
                copy($sourcePhoto, $destinationFullPath);

                $students[] = [
                    'class_room_id'  => $classRoomId,
                    'full_name'      => $name,
                    'call_name'      => $callName,
                    'sex'            => $sex,
                    'nis'            => $faker->unique()->numerify('19########'),
                    'phone'          => $faker->phoneNumber,
                    'religion'       => $faker->randomElement($religions),
                    'origin_school'  => $faker->company . ' School',
                    'birth_date'     => $faker->date('Y-m-d', '-15 years'),
                    'place_of_birth' => $faker->city,
                    'address'        => $faker->address,
                    'postal_code'    => $faker->postcode,
                    'admission_year' => $faker->year('-3 years'),
                    'father_name'    => $faker->name('male'),
                    'mother_name'    => $faker->name('female'),
                    'father_job'     => $faker->jobTitle,
                    'mother_job'     => $faker->jobTitle,
                    'photo'          => $destinationRelativePath,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];

                $i++;
            }
        }

        DB::table('users')->insert($users);

        $userIds = DB::table('users')
            ->orderBy('id', 'desc')
            ->take(count($students))
            ->pluck('id')
            ->reverse()
            ->values();

        foreach ($students as $index => $student) {
            $students[$index]['user_id'] = $userIds[$index];
        }

        DB::table('students')->insert($students);
    }
}
