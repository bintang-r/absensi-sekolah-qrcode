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

        $i = 1;
        $limit = 50;
        $students = [];
        $users = [];

        // Pastikan direktori storage/student-photos ada
        $storagePath = storage_path('app/public/student-photos');
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        while (true) {
            $sex = $faker->randomElement(config('const.sex'));
            $name = $faker->name($sex == 'laki-laki' ? 'male' : 'female');
            $callName = strtolower(explode(' ', trim($name))[0]);

            $users[] = [
                'username' => $name,
                'email'    => $callName . rand($i, $i * (1 - $i)) . '@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('student123'),
                'role'     => 'siswa',
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

            // Copy file ke storage/student-photos menggunakan move (simulasi store)
            copy($sourcePhoto, $destinationFullPath);

            $students[] = [
                'class_room_id'  => $faker->randomElement($classRoomIds),
                'full_name'      => $name,
                'call_name'      => $callName,
                'sex'            => $sex,
                'nis'            => $faker->unique()->numerify('19########'),
                'phone'          => $faker->phoneNumber,
                'religion'       => $faker->randomElement($religions),
                'origin_school'  => $faker->company . ' School',
                'birth_date'     => $faker->date('Y-m-d', '-25 years'),
                'place_of_birth' => $faker->city,
                'address'        => $faker->address,
                'postal_code'    => $faker->postcode,
                'admission_year' => $faker->year('-10 years'),
                'father_name'    => $faker->name('male'),
                'mother_name'    => $faker->name('female'),
                'father_job'     => $faker->jobTitle,
                'mother_job'     => $faker->jobTitle,
                'photo'          => $destinationRelativePath, // hanya student-photos/xxx
            ];

            $i++;

            if ($i >= $limit) {
                break;
            }
        }

        DB::table('users')->insert($users);

        $userIds = DB::table('users')
            ->orderBy('id', 'desc')
            ->take($limit)->pluck('id')
            ->reverse()
            ->values();

        $j = 0;
        while (true) {
            $students[$j]['user_id'] = $userIds[$j];

            $j++;

            if ($j >= count($students)) {
                break;
            }
        }

        DB::table('students')->insert($students);
    }
}
