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
        Schema::table('match_games', function (Blueprint $table) {
            $table->boolean('penalties_enabled')->default(false);
            $table->unsignedTinyInteger('team_a_penalties')->default(5);
            $table->unsignedTinyInteger('team_b_penalties')->default(5);
        });
    }

    public function down(): void
    {
        Schema::table('match_games', function (Blueprint $table) {
            $table->dropColumn([
                'penalties_enabled',
                'team_a_penalties',
                'team_b_penalties',
            ]);
        });
    }
};
