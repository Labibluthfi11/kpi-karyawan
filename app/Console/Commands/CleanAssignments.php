<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AssessmentAssignment;

class CleanAssignments extends Command
{
    protected $signature = 'assignments:clean';
    protected $description = 'Clean up duplicate assessment assignments';

    public function handle()
    {
        $assignments = AssessmentAssignment::all();
        $grouped = $assignments->groupBy(function($a) {
            return $a->evaluator_id . '-' . $a->evaluatee_id . '-' . $a->period_id;
        });

        $deletedCount = 0;
        foreach ($grouped as $group) {
            if ($group->count() > 1) {
                $toDelete = $group->slice(1);
                foreach ($toDelete as $item) {
                    $item->delete();
                    $deletedCount++;
                }
            }
        }
        $this->info("Deleted {$deletedCount} duplicate assignments.");
    }
}
