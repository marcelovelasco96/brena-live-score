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
            $table->string('broadcast_mode')->default('sports')->after('sport');
            $table->boolean('banner_enabled')->default(false)->after('broadcast_mode');
            $table->string('banner_label')->nullable()->after('banner_enabled');
            $table->string('banner_title')->nullable()->after('banner_label');
        });
    }

    public function down(): void
    {
        Schema::table('match_games', function (Blueprint $table) {
            $table->dropColumn([
                'broadcast_mode',
                'banner_enabled',
                'banner_label',
                'banner_title',
            ]);
        });
    }
};
