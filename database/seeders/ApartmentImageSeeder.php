<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ApartmentImageSeeder extends Seeder {
    public function run(): void {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            DB::table('apartment_images')->insert([
                'apartment_id' => $faker->numberBetween(1, 20),
                'image_path' => $faker->imageUrl(),
            ]);
        }
    }
}
