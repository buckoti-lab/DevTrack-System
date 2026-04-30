<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create  demo user
        User::create([
            'first_name' => 'Anovi',
            'second_name' => 'Yusuph',
            'last_name' => 'Buckoti',
            'role' => 'Admin',
            'email' => 'anoviyusuph@gmail.com',
            'password'=> Hash::make('1234567890'),
        ]);
    }
}
