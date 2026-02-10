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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('match_id')->constrained('matches')->cascadeOnDelete();
            $table->foreignId('avatar_id')->nullable()->constrained('avatars')->nullOnDelete();
            $table->string('nickname')->nullable();
            $table->unsignedInteger('score')->default(0);
            $table->unsignedTinyInteger('multiplier')->default(1);
            $table->json('votes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
