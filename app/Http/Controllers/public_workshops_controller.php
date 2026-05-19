<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class public_workshops_controller extends Controller
{
    public function index()
    {
        $workshops = Workshop::query()
            ->select(['id', 'name', 'description', 'photo_path', 'workshop_date', 'start_time', 'end_time', 'max_attendees', 'is_active'])
            ->orderBy('workshop_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get()
            ->map(fn(Workshop $workshop) => [
                'id' => $workshop->id,
                'name' => $workshop->name,
                'description' => $workshop->description,
                'photo_url' => $workshop->photo_path ? Storage::url($workshop->photo_path) : null,
                'workshop_date' => $workshop->workshop_date->toDateString(),
                'start_time' => substr($workshop->start_time, 0, 5),
                'end_time' => substr($workshop->end_time, 0, 5),
                'max_attendees' => $workshop->max_attendees,
                'is_active' => (bool) $workshop->is_active,
            ]);

        return Inertia::render('workshops/index', [
            'workshops' => $workshops,
        ]);
    }

    public function show(Workshop $workshop)
    {
        abort_if(!$workshop->is_active, 404);

        return Inertia::render('workshops/workshopdetails', [
            'workshop' => [
                'id' => $workshop->id,
                'name' => $workshop->name,
                'description' => $workshop->description,
                'photo_url' => $workshop->photo_path ? Storage::url($workshop->photo_path) : null,
                'workshop_date' => $workshop->workshop_date->toDateString(),
                'start_time' => substr($workshop->start_time, 0, 5),
                'end_time' => substr($workshop->end_time, 0, 5),
                'max_attendees' => $workshop->max_attendees,
            ],
        ]);
    }
}
