<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder {
    public function run(): void {
        $users = [
            [
                'username'       => 'Carlo',
                'email'      => 'caadfarlo.manconi@example.com',
                'password'   => 'Carlo12311',
                'date_birth' => '1974-08-08',
            ],
            [
                'username'       => 'Alice',
                'email'      => 'alice.johnson@example.com',
                'password'   => 'Password123',
                'date_birth' => '1974-08-08',
            ],
            [
                'username'       => 'Bob',
                'email'      => 'bob.smith@example.com',
                'password'   => 'SecurePass789',
                'date_birth' => '1974-08-08',
            ],
            [
                'username'       => 'Eva',
                'email'      => 'eva.anderson@example.com',
                'password'   => 'EvaPass456',
                'date_birth' => '1974-08-08',
            ],
            [
                'username'       => 'David',
                'email'      => 'david.brown@example.com',
                'password'   => 'BrownPass987',
                'date_birth' => '1974-08-08',
            ],
            [
                'username'       => 'Sophia',
                'email'      => 'sophia.lee@example.com',
                'password'   => 'LeePass321',
                'date_birth' => '1974-08-08',
            ],
            [
                'username'       => 'Michael',
                'email'      => 'michael.garcia@example.com',
                'password'   => 'GarciaPass246',
                'date_birth' => '1974-08-08',
            ],
            [
                'username'       => 'Olivia',
                'email'      => 'olivia.martinez@example.com',
                'password'   => 'MartinezPass789',
                'date_birth' => '1974-08-08',
            ],
            [
                'username'       => 'James',
                'email'      => 'james.taylor@example.com',
                'password'   => 'TaylorPass567',
                'date_birth' => '1974-08-08',
            ],
            [
                'username'       => 'Emma',
                'email'      => 'emma.white@example.com',
                'password'   => 'WhitePass123',
                'date_birth' => '1974-08-08',
            ],
            [
                'username'       => 'Liam',
                'email'      => 'liam.thomas@example.com',
                'password'   => 'ThomasPass890',
                'date_birth' => '1982-12-12',
            ],
            [
                'username'       => 'Mia',
                'email'      => 'mia.walker@example.com',
                'password'   => 'WalkerPass456',
                'date_birth' => '1982-12-12',
            ],
            [
                'username'       => 'Noah',
                'email'      => 'noah.johnson@example.com',
                'password'   => 'JohnsonPass789',
                'date_birth' => '1982-12-12',
            ],
            [
                'username'       => 'Ava',
                'email'      => 'ava.harris@example.com',
                'password'   => 'HarrisPass234',
                'date_birth' => '1982-12-12',
            ],
            [
                'username'       => 'William',
                'email'      => 'william.clark@example.com',
                'password'   => 'ClarkPass567',
                'date_birth' => '1982-12-12',
            ],
            [
                'username'       => 'Charlotte',
                'email'      => 'charlotte.lewis@example.com',
                'password'   => 'LewisPass890',
                'date_birth' => '1982-12-12',
            ],
            [
                'username'       => 'Logan',
                'email'      => 'logan.king@example.com',
                'password'   => 'KingPass123',
                'date_birth' => '1982-12-12',
            ],
            [
                'username'       => 'Harper',
                'email'      => 'harper.baker@example.com',
                'password'   => 'BakerPass456',
                'date_birth' => '1982-12-12',
            ],
            [
                'username'       => 'Lucas',
                'email'      => 'lucas.adams@example.com',
                'password'   => 'AdamsPass789',
                'date_birth' => '1982-12-12',
            ],
            [
                'username'       => 'Luna',
                'email'      => 'luna.parker@example.com',
                'password'   => 'ParkerPass234',
                'date_birth' => '1982-12-12',
            ],
            [
                'username'       => 'Henry',
                'email'      => 'henry.wright@example.com',
                'password'   => 'WrightPass567',
                'date_birth' => '1982-12-12',
            ],
            [
                'username'       => 'Ella',
                'email'      => 'ella.collins@example.com',
                'password'   => 'CollinsPass890',
                'date_birth' => '1990-03-12',
            ],
            [
                'username'       => 'Alexander',
                'email'      => 'alexander.hall@example.com',
                'password'   => 'HallPass123',
                'date_birth' => '1990-03-12',
            ],
            [
                'username'       => 'Grace',
                'email'      => 'grace.young@example.com',
                'password'   => 'YoungPass456',
                'date_birth' => '1990-03-12',
            ],
            [
                'username'       => 'Daniel',
                'email'      => 'daniel.miller@example.com',
                'password'   => 'MillerPass789',
                'date_birth' => '1990-03-12',
            ],
            [
                'username'       => 'Avery',
                'email'      => 'avery.hill@example.com',
                'password'   => 'HillPass234',
                'date_birth' => '1990-03-12',
            ],
            [
                'username'       => 'Jackson',
                'email'      => 'jackson.turner@example.com',
                'password'   => 'TurnerPass567',
                'date_birth' => '1990-03-12',
            ],
            [
                'username'       => 'Sofia',
                'email'      => 'sofia.gonzalez@example.com',
                'password'   => 'GonzalezPass890',
                'date_birth' => '1990-03-12',
            ],
            [
                'username'       => 'Lucas',
                'email'      => 'lucas.scott@example.com',
                'password'   => 'ScottPass123',
                'date_birth' => '1990-03-12',
            ],
            [
                'username'       => 'Lily',
                'email'      => 'lily.adams@example.com',
                'password'   => 'AdamsPass456',
                'date_birth' => '1990-03-12',
            ],
            [
                'username' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin123'),
                'date_birth' => '1990-03-12',
            ]
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
