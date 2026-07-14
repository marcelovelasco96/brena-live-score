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
        Schema::create('match_games', function (Blueprint $table) {
            $table->id();

            $table->string('sport')->default('football'); // football / volleyball
            $table->string('title')->nullable();

            $table->string('team_a_name')->default('LOCAL');
            $table->string('team_b_name')->default('VISITANTE');

            $table->integer('team_a_score')->default(0);
            $table->integer('team_b_score')->default(0);

            $table->integer('team_a_sets')->default(0);
            $table->integer('team_b_sets')->default(0);

            $table->integer('set_number')->default(1);

            $table->string('period')->default('1T');
            $table->integer('timer_seconds')->default(0);
            $table->boolean('timer_running')->default(false);

            $table->string('team_a_bg')->nullable();
            $table->string('team_b_bg')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_games');
    }
};
