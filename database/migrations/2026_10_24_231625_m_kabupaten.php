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
    Schema::create('m_kabupaten_kotas', function (Blueprint $table) {
      $table->id();

      $table->foreignId('provinsi_id')
        ->constrained('m_provinsis')
        ->cascadeOnUpdate()
        ->restrictOnDelete();

      $table->string('kode_kabupaten_kota', 10)->unique();
      $table->string('nama_kabupaten_kota', 150);

      $table->tinyInteger('status_aktif')->default(1);

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('m_kabupaten_kotas');
  }
};
