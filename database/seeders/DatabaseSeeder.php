<?php

namespace Database\Seeders;

use App\Models\User;
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
        
        User::create([
            'name' => 'Test',
            'email' => 'testAcount@gmail.com',
            'mobile' => '+971543099732',
            'password' => Hash::make('123456789'),
            'gender' => 'Male',
            'image' => 'https://services.asfarcogroup.com/media/1695899195.jpg', 
            'register_type' => 'email',
            'country_id' => 64,
        ]);
    
    }
}
