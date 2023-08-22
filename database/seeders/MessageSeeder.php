<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    public function run(): void {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            DB::table('user_messages')->insert([
                'user_id' => $faker->numberBetween(1, 10),
                'message' => $faker->paragraph,
                'email' => $faker->email,
            ]);
        }
    }
}
