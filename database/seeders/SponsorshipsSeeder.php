<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class SponsorshipsSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $faker = Faker::create();

        $sponsorships = [
            ['level' => 'Basic', 'price' => '50', 'duration' => '7 days'],
            ['level' => 'Premium', 'price' => '100', 'duration' => '14 days'],
            ['level' => 'Deluxe', 'price' => '150', 'duration' => '30 days'],
            // Add more sponsorships here
        ];

        foreach ($sponsorships as $sponsorship) {
            DB::table('sponsorships')->insert([
                'level' => $sponsorship['level'],
                'price' => $sponsorship['price'],
                'duration' => $sponsorship['duration'],
            ]);
        }
    }
}
