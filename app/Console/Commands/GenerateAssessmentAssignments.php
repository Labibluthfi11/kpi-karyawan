<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\AssessmentAssignment;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('kpi:generate-assignments')]
#[Description('Generate assessment assignments berdasarkan hirarki supervisor')]
class GenerateAssessmentAssignments extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai generate penugasan...');
        AssessmentAssignment::generate();
        $this->info('Penugasan berhasil di-generate!');
    }
}
