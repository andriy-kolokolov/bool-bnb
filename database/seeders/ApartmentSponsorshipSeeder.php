<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ApartmentSponsorshipSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $faker = Faker::create();

        $apartmentIds = DB::table('apartments')->pluck('id')->toArray();
        $sponsorshipIds = DB::table('sponsorships')->pluck('id')->toArray();

        foreach ($apartmentIds as $apartmentId) {
            // Randomly select a sponsorship for each apartment
            $sponsorshipId = $faker->randomElement($sponsorshipIds);

            // Generate random init and end dates
            $initDate = $faker->dateTimeBetween('-30 days', 'now');
            $endDate = $faker->dateTimeInInterval($initDate, '+30 days');

            DB::table('apartment_sponsorship')->insert([
                'apartment_id' => $apartmentId,
                'sponsorship_id' => $sponsorshipId,
                'init_date' => $initDate,
                'end_date' => $endDate,
            ]);
        }
    }
}
