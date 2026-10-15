<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('tracer_jawaban_details', function (Blueprint $table) {

      $table->id();

      // Tanpa Foreign Key
      $table->unsignedBigInteger('jawaban_id');

      $table->string('pilihan');

      $table->timestamps();

      $table->index('jawaban_id');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('tracer_jawaban_details');
  }
};
