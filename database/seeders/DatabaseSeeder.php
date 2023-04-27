<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserRolesSeeder::class
        ]);

         User::factory(20)->create([
             'role_id' => 2
         ]);

         User::factory()->create([
             'name' => 'Test User',
             'email' => 'sovkov.nema@gmail.com',
             'role_id' => 1,
             'password' => Hash::make('Admin1!@')
         ]);

        User::factory()->create([
            'name' => 'Test User2',
            'email' => 'sovkot.nema@gmail.com',
            'role_id' => 2,
            'password' => Hash::make('Admin1!@')
        ]);
    }
}
