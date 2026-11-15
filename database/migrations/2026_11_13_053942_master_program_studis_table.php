<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('master_program_studis', function (Blueprint $table) {
      $table->id();
      $table->foreignId('perguruan_tinggi_id')
        ->constrained('master_perguruan_tinggis')
        ->cascadeOnUpdate()
        ->cascadeOnDelete();
      $table->foreignId('jenjang_pendidikan_id')
        ->nullable()
        ->constrained('master_jenjang_pendidikans')
        ->cascadeOnUpdate()
        ->nullOnDelete();
      $table->string('kode', 10)->index();
      $table->string('nama', 150)->index();
      $table->string('status', 30)->nullable();
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('master_program_studis');
  }
};
