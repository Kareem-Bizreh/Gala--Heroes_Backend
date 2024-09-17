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
=======
        $this->call([
            ContactSeeder::class,
>>>>>>> 4a03ae8d70fa58981f288e0296e69fe87216612b
        ]);

        //db:seed

        $this->call(
            CategorySeeder::class
        );
    }
}
