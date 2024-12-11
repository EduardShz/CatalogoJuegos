<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Eduardo Sanchez',
            'username' => 'TheSilenceSoul',
            'role' => 'Administrador',
            'email' => 'josshdezsan@gmail.com',
            'password' => Hash::make('admin')
        ]);
        
        User::create([
            'name' => 'Jose Hernandez',
            'username' => 'Zythesia',
            'role' => 'Usuario',
            'email' => 'notzythesia@gmail.com',
            'password' => Hash::make('user')
        ]);
    }
}
