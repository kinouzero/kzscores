<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('games', function (Blueprint $table) {
      $table->id()->primary();
      $table->string('key');
      $table->string('name');
      $table->string('description')->nullable();
      $table->string('icon')->default('fas fa-dice');
      $table->string('color')->default('#000000');
      $table->timestamps();
    });

    Schema::create('game_options', function (Blueprint $table) {
      $table->foreignId('game_id')->constrained('games')->onUpdate('cascade')->onDelete('cascade');
      $table->foreignId('option_id')->constrained('options')->onUpdate('cascade')->onDelete('cascade');
      $table->primary(['game_id', 'option_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('games');
    Schema::dropIfExists('game_options');
  }
};
