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
            $table->string('team_a_logo')->nullable()->after('team_b_bg');
            $table->string('team_b_logo')->nullable()->after('team_a_logo');
            $table->string('team_a_background')->nullable()->after('team_b_logo');
            $table->string('team_b_background')->nullable()->after('team_a_background');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('match_games', function (Blueprint $table) {
            $table->dropColumn([
                'team_a_logo',
                'team_b_logo',
                'team_a_background',
                'team_b_background',
            ]);
        });
    }
};
