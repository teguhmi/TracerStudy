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

      $table->unsignedBigInteger('responden_id');
      $table->unsignedBigInteger('pertanyaan_id')->nullable();

      $table->string('kode_pertanyaan', 30);
      $table->longText('jawaban')->nullable();

      $table->timestamps();

      // Unique Key & Indexes
      $table->unique(['responden_id', 'kode_pertanyaan']);
      $table->index('responden_id');
      $table->index('kode_pertanyaan');

      // Foreign Keys
      $table->foreign('responden_id')
        ->references('id')
        ->on('tracer_respondens')
        ->cascadeOnDelete();

      $table->foreign('pertanyaan_id')
        ->references('id')
        ->on('tracer_pertanyaans')
        ->nullOnDelete();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('tracer_jawabans');
  }
};
