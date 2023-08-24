<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesSeeder extends Seeder {
    public function run(): void {
        $faker = Faker::create();

        $services = [
            ['name' => 'Cleaning', 'icon' => 'cleaning-icon.png'],
            ['name' => 'Maintenance', 'icon' => 'maintenance-icon.png'],
            ['name' => 'Security', 'icon' => 'security-icon.png'],
        ];

        foreach ($services as $service) {
            DB::table('services')->insert([
                'name' => $service['name'],
                'icon' => $service['icon'],
            ]);
        }

        // Generate additional random services
        for ($i = 0; $i < 20; $i++) {
            DB::table('services')->insert([
                'name' => $faker->word,
                'icon' => $faker->word . '-icon.png',
            ]);
        }
    }
}
