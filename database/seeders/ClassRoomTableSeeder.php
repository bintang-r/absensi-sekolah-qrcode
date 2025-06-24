<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassRoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        $listClass = [
            'I', 'II', 'III', 'IV', 'V', 'VI', 'VII',
            'VIII', 'IX', 'X', 'XI', 'XII', 'XIII'
        ];

        $classRooms = [];

        $i = 0;
        while (true) {
            $classRooms[] = [
                'name_class' => $listClass[$i],
                'description' => 'Kelas ' . $listClass[$i] . ' dengan total siswa ' . $faker->numberBetween(20, 40) . ' lokasi gedung ' . $faker->numberBetween(1, 3),
                'status_active' => $faker->boolean,
            ];

            $i++;

            if (($i + 1) >= count($listClass)) {
                break;
            }
        }

        DB::table('class_rooms')->insert($classRooms);
    }
}
