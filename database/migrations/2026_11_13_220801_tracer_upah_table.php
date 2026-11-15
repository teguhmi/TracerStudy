<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('tracer_upah', function (Blueprint $table) {
      $table->id();
      $table->string('kode');
      $table->string('nama');
      $table->year('tahun');
      $table->decimal('upah', 15, 2)->default(0);
      $table->timestamps();

      // Opsional: aktifkan jika kombinasi kode dan tahun harus unik
       $table->unique(['kode', 'tahun']);
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('tracer_upah');
  }
};
