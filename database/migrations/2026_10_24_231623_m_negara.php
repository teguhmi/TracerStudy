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
    Schema::create('m_negaras', function (Blueprint $table) {
      $table->bigIncrements('id');

      $table->string('kode_negara', 10)->unique();
      $table->string('nama_negara', 255);

      $table->tinyInteger('status_aktif')
        ->default(1)
        ->comment('1 = Aktif, 0 = Tidak Aktif');

      $table->timestamp('created_at')->useCurrent();
      $table->timestamp('updated_at')
        ->useCurrent()
        ->useCurrentOnUpdate();

      $table->index('status_aktif');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('m_negaras');
  }
};
