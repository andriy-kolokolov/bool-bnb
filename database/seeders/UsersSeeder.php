<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('users')->insert([
                'username' => $faker->userName(),
                'email' => $faker->unique()->safeEmail,
                'date_birth' => $faker->date,
                'password' => Hash::make('password123'), // Set your desired password
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
