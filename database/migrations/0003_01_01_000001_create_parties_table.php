<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('parties', function (Blueprint $table) {
      $table->id()->primary();
      $table->foreignId('game_id')->constrained('games')->onUpdate('cascade')->onDelete('cascade');
      $table->timestamps();
    });

    Schema::create('party_users', function (Blueprint $table) {
      $table->foreignId('party_id')->constrained('parties')->onUpdate('cascade')->onDelete('cascade');
      $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
      $table->integer('order');
      $table->json('score')->nullable();
      $table->boolean('current')->default(false);
      $table->boolean('winner')->default(false);
      $table->primary(['party_id', 'user_id']);
    });

    Schema::create('party_options', function (Blueprint $table) {
      $table->foreignId('party_id')->constrained('parties')->onUpdate('cascade')->onDelete('cascade');
      $table->foreignId('option_id')->constrained('options')->onUpdate('cascade')->onDelete('cascade');
      $table->string('value');
      $table->primary(['party_id', 'option_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('parties');
    Schema::dropIfExists('party_users');
    Schema::dropIfExists('party_options');
  }
};
