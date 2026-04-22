<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('admin/Mail/Index', [
            'mail' => [
                'mail_mailer' => (string) env('MAIL_MAILER', 'smtp'),
                'mail_scheme' => (string) env('MAIL_SCHEME', 'smtp'),
                'mail_host' => (string) env('MAIL_HOST', ''),
                'mail_port' => (string) env('MAIL_PORT', '587'),
                'mail_username' => (string) env('MAIL_USERNAME', ''),
                'mail_from_address' => (string) env('MAIL_FROM_ADDRESS', ''),
            ],
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
