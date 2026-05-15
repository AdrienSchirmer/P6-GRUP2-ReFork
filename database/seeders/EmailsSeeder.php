<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Email;

class EmailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            Email::create([
                'email' => "email{$i}@example.com",
                'active' => $i === 1 ? 1 : 0,
            ]);
        }
    }
}
