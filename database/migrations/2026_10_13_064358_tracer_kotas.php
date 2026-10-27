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

      $table->string('kode', 20)
        ->unique();

      $table->string('nama');

      $table->timestamps();

      $table->index('negara_id');
      $table->index('provinsi_id');
      $table->index('kode');
      $table->index('nama');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('tracer_kotas');
  }
};
