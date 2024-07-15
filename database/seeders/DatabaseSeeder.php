<?php

namespace Database\Seeders;

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
        User::factory(5)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        User::factory()->create([
          'name' => 'Saurabh Sharma',
          'email' => 'saurabh.sharma@nw.com',
       ]);
        User::factory()->create([
          'name' => 'Sudhir Kaushik',
          'email' => 'sudhir.kaushik@nw.com',
        ]);
    }
}
