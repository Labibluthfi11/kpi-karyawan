<?php

namespace App\Console\Commands;

use App\Models\AssessmentPeriod;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CyclePeriodCommand extends Command
{
    protected $signature = 'kpi:cycle-period';
    protected $description = 'Otomatis menutup periode aktif dan menyiapkan periode berikutnya';

    public function handle()
    {
        $today = Carbon::today();

        // 1. Logika Tutup Periode (Setelah tanggal 6)
        if ($today->day > 6) {
            $closed = AssessmentPeriod::where('is_active', true)
                ->update(['is_active' => false]);
            
            if ($closed) {
                $this->info('Periode aktif berhasil ditutup.');
            }
        }

        // 2. Logika Buka Periode (Tanggal 1)
        if ($today->day == 1) {
            $existing = AssessmentPeriod::where('is_active', true)->exists();
            if (!$existing) {
                $name = $today->format('F Y');
                AssessmentPeriod::create([
                    'name' => $name,
                    'start_date' => $today->startOfMonth(),
                    'end_date' => $today->copy()->endOfMonth(),
                    'is_active' => true,
                ]);
                $this->info("Periode $name berhasil dibuka.");
            }
        }
    }
}
