<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PharmacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pharmacies')->insert([
            [
                'name' => 'Farmacia Soler',
                'latitude' => '42.2655267',
                'longitude' => '2.9631527',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
