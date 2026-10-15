<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('tracer_kotas', function (Blueprint $table) {

      $table->id();

      $table->unsignedBigInteger('negara_id')
        ->nullable();

      $table->string('provinsi_id', 20)
        ->nullable();

      $table->string('kode_kabko', 20)
        ->unique();

      $table->string('nama_kabko');

      $table->timestamps();

      $table->index('negara_id');
      $table->index('provinsi_id');
      $table->index('kode_kabko');
      $table->index('nama_kabko');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('tracer_kotas');
  }
};
