<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Actions\Assignments\CreateAssignmentAction;
use App\Http\Requests\CreateAssignmentRequest;
use App\Models\Link;

class AssignmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Assignments/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Assignments/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAssignmentRequest $request, CreateAssignmentAction $createAssignment)
    {
        $validated = $request->validated();
        $assignment = $createAssignment->execute($validated);

        Inertia::flash([
            'message' => 'Ecarrec creat correctament',
        ]);

        return to_route('assignments.show');
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
