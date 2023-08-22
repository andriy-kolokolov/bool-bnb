<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApartmentsSeeder extends Seeder {
    public function run() {

        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            $apartmentId = DB::table('apartments')->insertGetId([
                'user_id' => $faker->numberBetween(1, 10),
                'name' => $faker->sentence(4),
                'rooms' => $faker->numberBetween(1, 5),
                'beds' => $faker->numberBetween(1, 3),
                'bathrooms' => $faker->numberBetween(1, 2),
                'square_meters' => $faker->numberBetween(50, 150),
                'is_available' => $faker->boolean,
                'is_sponsored' => $faker->boolean,
            ]);

            DB::table('apartment_address')->insert([
                'apartment_id' => $apartmentId,
                'zip' => $faker->postcode,
                'city' => $faker->city,
                'address' => $faker->address,
                'gps_coordinates' => $faker->latitude . ',' . $faker->longitude,
            ]);
        }
    }
}
