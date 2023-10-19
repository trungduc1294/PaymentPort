<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('prices')->insert([
            [
                'price' => 100,
                'price_code' => 'ADM',
                'description' => 'Audience Member',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price' => 200,
                'price_code' => 'AD',
                'description' => 'Audience',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price' => 50,
                'price_code' => 'ADSM',
                'description' => 'Audience Student Member',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price' => 100,
                'price_code' => 'ADS',
                'description' => 'Audience Student',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price' => 350,
                'price_code' => 'E1',
                'description' => 'Member with 1 np',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price' => 450,
                'price_code' => 'E2',
                'description' => 'Member with 2 np',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price' => 550,
                'price_code' => 'E3',
                'description' => 'Member with 3 np',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price' => 400,
                'price_code' => 'E4',
                'description' => 'non-member with 1 np',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price' => 500,
                'price_code' => 'E5',
                'description' => 'non-member with 2 np',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price' => 600,
                'price_code' => 'E6',
                'description' => 'non-member with 3 np',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price' => 250,
                'price_code' => 'SE1',
                'description' => 'Student member with 1 np',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price' => 300,
                'price_code' => 'SE2',
                'description' => 'student non-member with 1 np',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price' => 150,
                'price_code' => 'SVNE',
                'description' => 'Vietnamese student',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price' => 30,
                'price_code' => 'EP',
                'description' => 'Extra page',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
