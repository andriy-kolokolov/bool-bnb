<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class MessagesSeeder extends Seeder {
    public function run(): void {
        $faker = Faker::create();

        $apartmentIds = DB::table('apartments')->pluck('id')->toArray();

        foreach ($apartmentIds as $apartmentId) {
            DB::table('messages')->insert([
                'apartment_id' => $apartmentId,
                'guest_name' => $faker->name,
                'guest_email' => $faker->unique()->safeEmail,
                'message' => $faker->paragraph,
            ]);
        }
    }
}
