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
        Schema::table('kpi_questions', function (Blueprint $table) {
            $table->renameColumn('target_role', 'type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kpi_questions', function (Blueprint $table) {
            $table->renameColumn('type', 'target_role');
        });
    }
};
