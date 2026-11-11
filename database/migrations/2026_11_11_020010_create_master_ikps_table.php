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
    Schema::create('master_ikps', function (Blueprint $table) {
      $table->id();

      $table->string('kode', 50)->unique();
      $table->string('nama', 100);

      $table->timestamps();

      $table->index('kode');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('master_ikps');
  }
};
