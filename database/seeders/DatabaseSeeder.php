<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // delete old files and directories
        File::deleteDirectory(public_path('storage/avatars'));
        Storage::deleteDirectory('public/avatars');

        // call the seeders
        $this->call([
            UserTableSeeder::class,
            ClassRoomTableSeeder::class,
        ]);
    }
}
