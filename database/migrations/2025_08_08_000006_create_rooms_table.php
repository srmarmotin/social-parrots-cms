<?php

declare(strict_types=1);

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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('code', 12)->unique();
            $table->foreignId('game_id')->constrained('games')->cascadeOnDelete();
            $table->foreignId('leader_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedTinyInteger('max_players')->default(8);
            $table->enum('status', ['waiting', 'active', 'finished', 'cancelled'])->default('waiting');
            $table->json('settings')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
