<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PharmacyGuardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pharmacy_guards')->insert([
            [
                'date' => '2026-05-01',
                'pharmacy_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => '2026-05-02',
                'pharmacy_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => '2026-05-03',
                'pharmacy_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => '2026-05-04',
                'pharmacy_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => '2026-05-05',
                'pharmacy_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => '2026-05-06',
                'pharmacy_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => '2026-05-7',
                'pharmacy_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => '2026-05-08',
                'pharmacy_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => '2026-05-09',
                'pharmacy_id' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => '2026-05-10',
                'pharmacy_id' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => '2026-05-11',
                'pharmacy_id' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => '2026-05-12',
                'pharmacy_id' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => '2026-05-13',
                'pharmacy_id' => 13,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => '2026-05-14',
                'pharmacy_id' => 14,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
