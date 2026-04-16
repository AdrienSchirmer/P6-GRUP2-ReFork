<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@farmaciasoler.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('knqm4141'),
                'role' => 'superadmin',
                'email_verified_at' => now(),
                'updated_at' => now(),
                'created_at' => now(),
            ],
        );
    }
}
