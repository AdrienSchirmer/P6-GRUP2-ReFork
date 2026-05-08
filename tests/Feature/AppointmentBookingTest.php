<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\ServiceSchedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentBookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_and_pdf_generation_flow()
    {
        // Setup service with schedule
        $service = Service::factory()->create([
            'duration_minutes' => 30,
        ]);
        
        ServiceSchedule::factory()->create([
            'service_id' => $service->id,
            'day_of_week' => 3, // Wednesday
            'start_time' => '09:00',
            'end_time' => '17:00',
        ]);

        // Book appointment
        $appointmentData = [
            'service_id' => $service->id,
            'customer_name' => 'Jane Doe',
            'customer_phone' => '666777888',
            'customer_email' => 'jane@example.com',
            'appointment_date' => '2026-05-13', // Next Wednesday
            'start_time' => '14:00',
            'cf-turnstile-response' => 'valid-token', // Mock in your test setup
        ];

        $response = $this->post('/appointments', $appointmentData);
        
        // Check appointment was created
        $this->assertDatabaseHas('service_appointments', [
            'customer_name' => 'Jane Doe',
            'customer_email' => 'jane@example.com',
        ]);

        // Download PDF with returned data
        $pdfResponse = $this->get('/appointments/pdf', [
            'service' => $service->id,
            'date' => '2026-05-13',
            'time' => '14:00',
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);

        $pdfResponse->assertStatus(200);
        $pdfResponse->assertHeader('Content-Type', 'application/pdf');
    }
}