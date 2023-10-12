<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $users = User::get();
        foreach ($users as $user) {
            $user->update([
                'Verify_at' => $user->created_at
            ]);
        }

    
    }
}
