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
            $table->string('team_a_jersey_color')->default('#1e40af')->after('team_b_color');
            $table->string('team_b_jersey_color')->default('#dc2626')->after('team_a_jersey_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('match_games', function (Blueprint $table) {
            $table->dropColumn([
                'team_a_jersey_color',
                'team_b_jersey_color',
            ]);
        });
    }
};
