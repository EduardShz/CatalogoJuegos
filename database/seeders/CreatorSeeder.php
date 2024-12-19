<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Creator;
use Illuminate\Database\Seeder;

class CreatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Creator::create([
            'name' => 'Epic Games'
        ]);
        Creator::create([
            'name' => 'Rockstar'
        ]);
        Creator::create([
            'name' => 'HoyoVerse'
        ]);
        Creator::create([
            'name' => 'Riot Games'
        ]);
        Creator::create([
            'name' => 'Microsoft'
        ]); 
        Creator::create([
            'name' => 'Nintendo'
        ]);
        Creator::create([
            'name' => 'Sony'
        ]);
        Creator::create([
            'name' => 'Insomiac'
        ]);
        Creator::create([
            'name' => 'Mojang'
        ]);
    }
}
