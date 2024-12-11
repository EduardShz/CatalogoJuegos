<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Genre::create([
            'name' => 'Battle Royale'
        ]);
        Genre::create([
            'name' => 'Acción'
        ]);
        Genre::create([
            'name' => 'Aventura'
        ]);
        Genre::create([
            'name' => 'FPS'
        ]);
        Genre::create([
            'name' => 'RPG'
        ]);
        Genre::create([
            'name' => 'Deportes'
        ]);
        Genre::create([
            'name' => 'MOBA'
        ]);
        Genre::create([
            'name' => 'Survival Honor'
        ]);
        Genre::create([
            'name' => 'Mundo Abierto'
        ]);
        Genre::create([
            'name' => 'Peleas'
        ]);
        Genre::create([
            'name' => 'Simulación'
        ]);
    }
}
