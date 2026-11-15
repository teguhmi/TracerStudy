<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('tracer_respondens', function (Blueprint $table) {
      $table->id();

      $table->unsignedBigInteger('periode_id')->nullable();
      $table->unsignedBigInteger('kategori_id')->nullable();

      $table->string('nim', 20);
      $table->string('nama')->nullable();
      $table->string('nik', 20)->nullable();
      $table->string('npwp', 30)->nullable();
      $table->string('email', 150)->nullable();
      $table->string('telepon', 30)->nullable();
      $table->text('alamat_lengkap')->nullable();

      $table->unsignedBigInteger('negara_id')->nullable();
      $table->unsignedBigInteger('provinsi_id')->nullable();
      $table->unsignedBigInteger('kabupaten_id')->nullable();

      $table->date('tanggal_lulus')->nullable();
      $table->timestamp('tanggal_mulai')->nullable();
      $table->timestamp('tanggal_submit')->nullable();

      $table->enum('status', [
        'draft',
        'submitted',
        'validated',
      ])->default('draft');

      $table->timestamps();

      // Unique Key & Indexes
      $table->unique(['kategori_id', 'nim'], 'tracer_respondens_periode_id_nim_unique');
      $table->index('periode_id');
      $table->index('kategori_id');
      $table->index('nim');
      $table->index('status');

      // Foreign Keys
      $table->foreign('periode_id')
        ->references('id')
        ->on('tracer_periodes')
        ->cascadeOnDelete();

      $table->foreign('kategori_id')
        ->references('id')
        ->on('tracer_kategoris')
        ->nullOnDelete();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('tracer_respondens');
  }
};
