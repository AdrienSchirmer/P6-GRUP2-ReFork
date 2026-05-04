<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PharmacyGuardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pharmacy_guards')->insert([
            [
                'date' => '2026-04-27',
                'pharmacy_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);   
    }
}
