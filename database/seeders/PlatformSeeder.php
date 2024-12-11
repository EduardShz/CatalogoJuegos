<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Platform;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Platform::create([
            'name' => 'PlayStation'
        ]);
        Platform::create([
            'name' => 'PlayStation 5'
        ]);
        Platform::create([
            'name' => 'PlayStation 4'
        ]);
        Platform::create([
            'name' => 'Xbox Series'
        ]);
        Platform::create([
            'name' => 'Nintendo Switch'
        ]);
        Platform::create([
            'name' => 'PC'
        ]);
        Platform::create([
            'name' => 'Celular'
        ]);
    }
}
