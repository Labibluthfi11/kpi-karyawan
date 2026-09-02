<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kpi_questions', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // Sikap, Kehadiran, Produktivitas
            $table->text('question_text');
            $table->string('target_role'); // Supervisor, Leader, Anggota
            $table->timestamps();
        });

        Schema::create('kpi_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluator_id')->constrained('users');
            $table->foreignId('evaluatee_id')->constrained('users');
            $table->date('assessment_date');
            $table->timestamps();
        });

        Schema::create('kpi_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('kpi_assessments')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('kpi_questions');
            $table->integer('score'); // 1-5
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kpi_results');
        Schema::dropIfExists('kpi_assessments');
        Schema::dropIfExists('kpi_questions');
    }
};
