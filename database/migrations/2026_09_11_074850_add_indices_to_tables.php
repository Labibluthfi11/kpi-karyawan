<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->index('department_id');
            $table->index('role_id');
        });

        Schema::table('assessment_assignments', function (Blueprint $table) {
            $table->index('evaluator_id');
            $table->index('evaluatee_id');
        });

        Schema::table('kpi_assessments', function (Blueprint $table) {
            $table->index('evaluator_id');
            $table->index('evaluatee_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['department_id']);
            $table->dropIndex(['role_id']);
        });

        Schema::table('assessment_assignments', function (Blueprint $table) {
            $table->dropIndex(['evaluator_id']);
            $table->dropIndex(['evaluatee_id']);
        });

        Schema::table('kpi_assessments', function (Blueprint $table) {
            $table->dropIndex(['evaluator_id']);
            $table->dropIndex(['evaluatee_id']);
        });
    }
};
