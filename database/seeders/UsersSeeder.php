<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder {
    public function run(): void {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('users')->insert([
                'username' => $faker->userName,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'), // You might adjust this as needed
                'date_birth' => $faker->date,
            ]);
        }

        User::create([
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'date_birth' => $faker->date,
        ]);
    }
}
