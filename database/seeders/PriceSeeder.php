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
                'price' => 150,
                'price_code' => 'audience',
                'description' => 'Audience Registration',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price' => 200,
                'price_code' => 'researcher',
                'description' => 'researcher presenter',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price' => 100,
                'price_code' => 'student',
                'description' => 'student presenter',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price' => 50,
                'price_code' => 'EP',
                'description' => 'Extra page',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
