<?php

namespace App\Observers;

use App\Models\User;
use App\Models\AssessmentAssignment;

class AssignmentObserver
{
    public function created(User $user): void
    {
        AssessmentAssignment::generate();
    }

    public function updated(User $user): void
    {
        // Refresh when department or role changes
        if ($user->wasChanged(['department_id', 'role_id'])) {
            AssessmentAssignment::generate();
        }
    }
}
