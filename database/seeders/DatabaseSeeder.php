<?php

namespace Database\Seeders;

use App\Models\Divisions;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([            
        //     'username' => 'admin',
        //     'email' => 'admin@egmail.com',
        //     'password' => 'pastibisa',
        //     'phone' => '08000000001'
        // ]);

        Divisions::factory()->create([
            'name' => 'Mobile Apps'
        ]);

        Divisions::factory()->create([
            'name' => 'QA'
        ]);

        Divisions::factory()->create([
            'name' => 'Full Stack'
        ]);

        Divisions::factory()->create([
            'name' => 'Backend'
        ]);

        Divisions::factory()->create([
            'name' => 'Frontend'
        ]);

        Divisions::factory()->create([
            'name' => 'UI/UX Designer'
        ]);
    }
}
