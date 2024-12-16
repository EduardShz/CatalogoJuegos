<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Eduardo Sanchez',
            'username' => 'TheSilenceSoul',
            'email' => 'josshdezsan@gmail.com',
            'password' => Hash::make('Uzumaki_0211')
        ]);
        $admin->assignRole('admin');
        
        $user = User::create([
            'name' => 'Jose Hernandez',
            'username' => 'Zythesia',
            'email' => 'notzythesia@gmail.com',
            'password' => Hash::make('user')
        ]);
        $user->assignRole('user');
    }
}
