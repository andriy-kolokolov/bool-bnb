<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        $this->call(UsersSeeder::class);
        $this->call(ApartmentsSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(ApartmentServiceSeeder::class);
        $this->call(MessageSeeder::class);
        $this->call(ApartmentImageSeeder::class);
    }
}
