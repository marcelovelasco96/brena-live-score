<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('match_games', function (Blueprint $table) {
            $table->dropColumn(['team_a_penalties', 'team_b_penalties']);
        });

        Schema::table('match_games', function (Blueprint $table) {
            $table->json('team_a_penalties')->nullable();
            $table->json('team_b_penalties')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('match_games', function (Blueprint $table) {
            $table->dropColumn(['team_a_penalties', 'team_b_penalties']);
        });

        Schema::table('match_games', function (Blueprint $table) {
            $table->unsignedTinyInteger('team_a_penalties')->default(5);
            $table->unsignedTinyInteger('team_b_penalties')->default(5);
        });
    }
};
