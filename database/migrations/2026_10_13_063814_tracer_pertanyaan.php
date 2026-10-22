<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('tracer_pertanyaans', function (Blueprint $table) {

      $table->id();

      // Relasi tanpa FK
      $table->unsignedBigInteger('section_id')->nullable();
      $table->unsignedBigInteger('kategori_id')->nullable();

      $table->string('kode', 30)->unique();

      $table->string('parent_kode', 30)->nullable();

      $table->text('pertanyaan');

      $table->enum('jenis', [
        'text',
        'textarea',
        'number',
        'date',
        'radio',
        'checkbox',
        'select',
        'matrix',
        'label',
        'email'

      ]);

      $table->boolean('wajib')->default(true);

      $table->json('tampil_jika')->nullable();

      $table->integer('urutan')->default(0);

      $table->boolean('aktif')->default(true);

      $table->timestamps();

      // Index
      $table->index('section_id');
      $table->index('kategori_id');
      $table->index('kode');
      $table->index('parent_kode');
      $table->index('urutan');
      $table->index('aktif');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('tracer_pertanyaans');
  }
};
