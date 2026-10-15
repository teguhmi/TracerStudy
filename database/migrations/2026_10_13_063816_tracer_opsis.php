<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('tracer_opsis', function (Blueprint $table) {

      $table->id();

      // Tanpa Foreign Key
      $table->unsignedBigInteger('pertanyaan_id');

      $table->string('nilai', 100);

      $table->string('label');

      $table->integer('urutan')
        ->default(0);

      $table->boolean('aktif')
        ->default(true);

      $table->timestamps();

      $table->index('pertanyaan_id');
      $table->index('urutan');
      $table->index('aktif');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('tracer_opsis');
  }
};
