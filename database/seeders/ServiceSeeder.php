<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder {
    public function run(): void {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('services')->insert([
                'name' => $faker->word,
            ]);
        }
    }
}
