<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ViewsSeeder extends Seeder {
    public function run(): void {
        $faker = Faker::create();

        $apartmentIds = DB::table('apartments')->pluck('id')->toArray();

        foreach ($apartmentIds as $apartmentId) {
            // Generate a random number of views per apartment
            $numViews = $faker->numberBetween(10, 200);

            for ($i = 0; $i < $numViews; $i++) {
                DB::table('views')->insert([
                    'apartment_id' => $apartmentId,
                    'ip' => $faker->ipv4,
                    'date_time' => $faker->dateTimeThisYear,
                ]);
            }
        }
    }
}
