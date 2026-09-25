<?php

namespace App\Console\Commands;

use App\Models\AssessmentAssignment;
use App\Notifications\AssignmentReminder;
use Illuminate\Console\Command;

class SendRemindersCommand extends Command
{
    protected $signature = 'kpi:send-reminders';
    protected $description = 'Mengirim pengingat ke evaluator yang belum menyelesaikan penilaian';

    public function handle()
    {
        // 1. Cari assignment yang belum selesai (pending)
        // Pastikan hanya mengambil yang memiliki evaluator (aktif)
        $pendingAssignments = AssessmentAssignment::where('status', 'pending')
            ->whereHas('evaluator') 
            ->with(['evaluator'])
            ->get();

        if ($pendingAssignments->isEmpty()) {
            $this->info('Tidak ada penilaian yang tertunda.');
            return;
        }

        // 2. Kelompokkan berdasarkan evaluator untuk efisiensi notifikasi
        $grouped = $pendingAssignments->groupBy('evaluator_id');

        foreach ($grouped as $evaluatorId => $assignments) {
            $evaluator = $assignments->first()->evaluator;
            $count = $assignments->count();

            // 3. Notifikasi melalui Email
            $evaluator->notify(new AssignmentReminder($count));
            
            $this->info("Reminder terkirim ke {$evaluator->name} ({$count} penilaian).");
        }
    }
}
