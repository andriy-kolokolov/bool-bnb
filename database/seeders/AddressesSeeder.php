<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressesSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $faker = Faker::create();

        $apartments = DB::table('apartments')->pluck('id')->toArray();

        foreach ($apartments as $apartmentId) {
            DB::table('addresses')->insert([
                'apartment_id' => $apartmentId,
                'street' => $faker->streetAddress,
                'city' => $faker->city,
                'zip' => $faker->postcode,
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude,
            ]);
        }
    }
}
