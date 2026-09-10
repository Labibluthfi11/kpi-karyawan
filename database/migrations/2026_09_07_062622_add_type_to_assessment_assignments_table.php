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
        Schema::table('assessment_assignments', function (Blueprint $table) {
            $table->string('type')->default('leader_to_team'); // leader_to_team, team_to_leader, leader_to_leader
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessment_assignments', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
