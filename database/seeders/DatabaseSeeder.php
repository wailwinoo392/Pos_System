<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone'=> '9876543',
            'address' => 'mawlamyine',
            'gender' => 'male',
            'role' => 'admin',
            'password' => Hash::make('wailwinoo')
        ]);
        User::create([
            'name' => 'Wai Lwin Oo',
            'email' => 'wai@gmail.com',
            'phone'=> '987654321',
            'address' => 'mawlamyine',
            'gender' => 'male',
            'role' => 'user',
            'password' => Hash::make('wailwinoo')
        ]);
        User::create([
            'name' => 'Joker',
            'email' => 'jok@gmail.com',
            'phone'=> '987654322',
            'address' => 'Ye',
            'gender' => 'female',
            'role' => 'user',
            'password' => Hash::make('wailwinoo')
        ]);
        
        
        
        
    }
}