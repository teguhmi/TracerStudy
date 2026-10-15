<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('tracer_periodes', function (Blueprint $table) {
      $table->id();

      $table->string('nama_periode');
      $table->year('tahun_mulai')->nullable();
      $table->year('tahun_selesai')->nullable();

      $table->boolean('aktif')->default(false);

      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('tracer_periodes');
  }
};
