<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ImagesSeeder extends Seeder {
    public function run(): void {
        $faker = Faker::create();

        $apartmentIds = DB::table('apartments')->pluck('id')->toArray();

        foreach ($apartmentIds as $apartmentId) {
            // Generate a random number of images per apartment
            $numImages = $faker->numberBetween(1, 5);

            for ($i = 0; $i < $numImages; $i++) {
                $imageWidth = $faker->numberBetween(800, 1200);
                $imageHeight = $faker->numberBetween(600, 900);
                $imagePath = "https://picsum.photos/{$imageWidth}/{$imageHeight}";

                DB::table('images')->insert([
                    'apartment_id' => $apartmentId,
                    'image_path' => $imagePath,
                    'is_cover' => ($i === 0), // Set the first image as the cover
                ]);
            }
        }
    }
}
