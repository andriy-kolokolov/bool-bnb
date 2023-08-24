<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        $this->call([
            UsersSeeder::class,
            ApartmentsSeeder::class,
            ServicesSeeder::class,
            AddressesSeeder::class,
            ApartmentServiceSeeder::class,
            MessagesSeeder::class,
            ImagesSeeder::class,
            SponsorshipsSeeder::class,
            ApartmentSponsorshipSeeder::class,
            ViewsSeeder::class,
        ]);
    }
}
