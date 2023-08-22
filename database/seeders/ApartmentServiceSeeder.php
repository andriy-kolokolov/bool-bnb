<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApartmentServiceSeeder extends Seeder {
    /**
     * Run the database seeds.
     * @throws \Exception
     */
    public function run(): void {
        foreach (range(1, 20) as $index) {
            DB::table('apartment_service')->insert([
                'apartment_id' => random_int(1, 20),
                'service_id' => random_int(1, 10),
            ]);
        }
    }
}
