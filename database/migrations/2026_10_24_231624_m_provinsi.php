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
    Schema::create('m_provinsis', function (Blueprint $table) {
      $table->id();

      $table->foreignId('negara_id')
        ->constrained('m_negaras')
        ->cascadeOnUpdate()
        ->restrictOnDelete();

      $table->string('kode_provinsi', 10)->unique();
      $table->string('nama_provinsi', 150);

      $table->tinyInteger('status_aktif')->default(1);

      $table->timestamp('created_at')->useCurrent();

      $table->timestamp('updated_at')
        ->useCurrent()
        ->useCurrentOnUpdate();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('m_provinsis');
  }
};
