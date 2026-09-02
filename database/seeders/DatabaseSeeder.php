<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Seed Departments
        $itDept = \App\Models\Department::create(['name' => 'IT']);

        // 2. Seed Roles
        $roleAdmin = \App\Models\Role::create(['name' => 'Admin']);
        $roleSupervisor = \App\Models\Role::create(['name' => 'Supervisor']);
        $roleLeader = \App\Models\Role::create(['name' => 'Leader']);
        $roleAnggota = \App\Models\Role::create(['name' => 'Anggota']);

        // 3. Seed Users (Admin & Testing Users)
        \App\Models\User::create([
            'name' => 'Admin HRD',
            'email' => 'admin@kpi.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role_id' => $roleAdmin->id,
            'department_id' => $itDept->id,
            'pin' => '0000',
        ]);

        \App\Models\User::create([
            'name' => 'Budi Leader',
            'email' => 'budi@kpi.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role_id' => $roleLeader->id,
            'department_id' => $itDept->id,
            'pin' => '1234',
        ]);

        // 4. Seed KPI Questions
        $questions = [
            ['category' => 'Sikap', 'question_text' => 'Menunjukkan perilaku profesional', 'target_role' => 'Leader'],
            ['category' => 'Kehadiran', 'question_text' => 'Tepat waktu', 'target_role' => 'Leader'],
            ['category' => 'Produktivitas', 'question_text' => 'Mencapai target harian', 'target_role' => 'Leader'],
            ['category' => 'Sikap', 'question_text' => 'Kerjasama tim baik', 'target_role' => 'Anggota'],
            ['category' => 'Kehadiran', 'question_text' => 'Jarang absen', 'target_role' => 'Anggota'],
            ['category' => 'Produktivitas', 'question_text' => 'Kualitas kerja baik', 'target_role' => 'Anggota'],
        ];
        
        foreach ($questions as $q) {
            \App\Models\KpiQuestion::create($q);
        }
    }
}
