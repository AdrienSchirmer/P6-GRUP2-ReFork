<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Email;
use App\Actions\Emails\CreateEmailAction;
use App\Http\Requests\CreateEmailRequest;

class EmailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emails = Email::orderBy('email')->orderByDesc('active')->get();

        return Inertia::render('admin/Emails/Index', [
            'emails' => $emails,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/Emails/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEmailRequest $request, CreateEmailAction $createEmail)
    {
        $validated = $request->validated();
        $createEmail->execute($validated);

        Inertia::flash([
            'message' => 'Correu electrònic creat correctament.',
        ]);

        return redirect('/admin/emails');
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
