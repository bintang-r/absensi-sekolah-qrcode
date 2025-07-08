<?php

namespace Database\Seeders;

use App\Models\WhatsappConfig;
use Illuminate\Database\Seeder;

class WhatsappConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WhatsappConfig::create([
            'url' => 'http://localhost:300',
            'port' => '3000',
            'phone_number' => '6282194243813',
        ]);
    }
}
