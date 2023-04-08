<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(class: SchoolSeeder::class);
        $this->call(class: UserSeeder::class);
        $this->call(class: GuardianSeeder::class);
    }
}
