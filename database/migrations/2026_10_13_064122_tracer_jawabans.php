<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('tracer_jawabans', function (Blueprint $table) {

      $table->id();

      // Tanpa Foreign Key
      $table->unsignedBigInteger('responden_id');

      $table->string('kode_pertanyaan', 30);

      $table->longText('jawaban')->nullable();

      $table->timestamps();

      $table->index('responden_id');
      $table->index('kode_pertanyaan');

      $table->unique([
        'responden_id',
        'kode_pertanyaan'
      ]);
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('tracer_jawabans');
  }
};
