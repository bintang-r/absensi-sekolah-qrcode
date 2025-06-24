<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        for ($i = 1; $i <= count($listClass); $i++) {
            $classRooms[] = [
                'name_class' => $listClass[$i - 1],
                'description' => 'Kelas ' . $listClass[$i - 1],
                'status_active' => $faker->boolean,
            ];
        }

        foreach ($classRooms as $classRoom) {
            DB::table('class_rooms')->insert($classRoom);
        }
    }
}
