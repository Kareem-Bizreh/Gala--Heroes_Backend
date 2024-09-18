<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

<<<<<<< HEAD
        User::factory()->create([
            'full_name' => 'Test User',
            'email' => 'test@example.com',
        ]);
=======
        // User::factory()->create([
        //     'full_name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
>>>>>>> ecf468351aec9da70a98c40d8f8a65328e53d475

        //db:seed

        $this->call(
            ContactSeeder::class,
            CategorySeeder::class
        );
    }
}
