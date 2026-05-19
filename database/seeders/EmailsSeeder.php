<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('emails')->insert([
            [
                'email' => 'brandonalcantara@proton.me',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'charfahilyass@gmail.com',
                'active' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'adrienmolina94@gmail.com',
                'active' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'franolivera2005@gmail.com',
                'active' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'sllado1@cendrassos.net',
                'active' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'edprados@cendrassos.net',
                'active' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'solaimanbaraka1@gmail.com',
                'active' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
