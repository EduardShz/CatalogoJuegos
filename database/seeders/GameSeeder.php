<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $game1 = Game::create([
            'name' => 'Spider-Man (2018)',
            'published_year' => '2018',
            'rating' => 5,
            'creator_id' => 8,  
        ]);
        $game1->platforms()->attach([1, 2]); 
        $game1->genres()->attach([2, 9]);

        $game2 = Game::create([
            'name' => 'Red Dead Redemption 2',
            'published_year' => '2018',
            'rating' => 5,
            'creator_id' => 2, 
        ]);
        $game2->platforms()->attach([1, 2, 5, 3]); 
        $game2->genres()->attach([2, 3, 9]);  

        $game3 = Game::create([
            'name' => 'Minecraft',
            'published_year' => '2010',
            'rating' => 5,
            'creator_id' => 9,  
        ]);
        $game3->platforms()->attach([1, 2, 3, 4, 5, 6]);
        $game3->genres()->attach([3, 12]);
    }
}
