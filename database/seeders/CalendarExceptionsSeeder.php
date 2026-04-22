<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CalendarExceptionsSeeder extends Seeder
{
    /**
     * Seed Figueres non-working days 2026.
     */
    public function run(): void
    {
        $now = now();
        $days = [
            '2026-01-01 00:00:00',
            '2026-01-06 00:00:00',
            '2026-04-03 00:00:00',
            '2026-04-06 00:00:00',
            '2026-05-01 00:00:00',
            '2026-05-25 00:00:00',
            '2026-06-24 00:00:00',
            '2026-06-29 00:00:00',
            '2026-08-15 00:00:00',
            '2026-09-11 00:00:00',
            '2026-10-12 00:00:00',
            '2026-12-08 00:00:00',
            '2026-12-25 00:00:00',
            '2026-12-26 00:00:00',
        ];

        foreach ($days as $day) {
            DB::table('calendar_exceptions')->updateOrInsert(
                ['day' => $day],
                ['created_at' => $now, 'updated_at' => $now],
            );
        }
    }
}
