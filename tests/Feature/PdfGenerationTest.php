<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\ServiceAppointment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PdfGenerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_pdf_download_with_valid_appointment()
    {
        $service = Service::factory()->create(['duration_minutes' => 30]);
        
        $response = $this->get('/appointments/pdf', [
            'service' => $service->id,
            'date' => '2026-05-15',
            'time' => '14:00',
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
        $response->assertHeader('Content-Disposition', 'attachment');
    }

    public function test_pdf_download_requires_valid_service()
    {
        $response = $this->get('/appointments/pdf', [
            'service' => 999,
            'date' => '2026-05-15',
            'time' => '14:00',
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $response->assertStatus(404);
    }
}