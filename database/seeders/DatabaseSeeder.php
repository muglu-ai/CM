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
        // Call the sample data seeder which creates an admin user,
        // events, sessions, speakers and pivot roles.
        $this->call([
            SampleDataSeeder::class,
            TracksSeeder::class,
        ]);
    }
}
