<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApartmentsSeeder extends Seeder {
    public function run(): void {

        $faker = Faker::create();

        foreach (range(1, 100) as $index) {
            DB::table('apartments')->insert([
                'user_id' => $faker->numberBetween(1, 10), // Assuming 10 users exist
                'name' => $faker->sentence,
                'rooms' => $faker->numberBetween(1, 5),
                'beds' => $faker->numberBetween(1, 3),
                'bathrooms' => $faker->numberBetween(1, 3),
                'square_meters' => $faker->numberBetween(50, 200),
                'is_available' => $faker->boolean,
                'is_sponsored' => $faker->boolean,
            ]);
        }
    }
}
