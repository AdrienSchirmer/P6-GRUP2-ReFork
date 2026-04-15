<?php

namespace App\Actions\Assignments;

use App\Models\assignments;

class CreateAssignmentAction
{
    public function execute(array $data): assignments
    {
        $assignment = new assignments;
        $assignment->name = $data['name'];
        $assignment->address = $data['address'];
        $assignment->phone_number = $data['phone_number'];
        $assignment->description = $data['description'];
        $assignment->save();

        return $assignment;
    }
}