<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Inertia\Inertia;
use App\Http\Resources\ServiceResource;
use App\Http\Controllers\Controller;
use App\Models\ServiceAppointment;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*
     return Inertia::render('PedirCita', [
        'services' => ServiceResource::collection(Service::all())
    ]);
    */
        return Inertia::render('PedirCita', [
            'services' => Service::all()->map(function ($service) {
                return [
                    'id' => $service->id,
                    'nom' => $service->name,
                    'descripció' => $service->description,
                    'durada' => $service->duration_minutes . ' min',
                    'icon' => $service->icon,
                ];
            })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'customer_name' => 'required|string|max:255',

            'customer_phone' => ['required','regex:/^[0-9]{9}$/'],
            'customer_email' => 'required|email|max:255',
            'appointment_date' => 'required|date',
            'start_time' => 'required',
        ]);

        ServiceAppointment::create([
            'service_id' => $validated['service_id'],
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_email' => $validated['customer_email'],
            'appointment_date' => $validated['appointment_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['start_time'],
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Reserva confirmada');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
