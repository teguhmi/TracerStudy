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

      // Tanpa Foreign Key
      $table->unsignedBigInteger('periode_id')->nullable();

      $table->string('nim', 20);

      $table->string('nama')->nullable();

      $table->date('tanggal_lulus')->nullable();

      $table->timestamp('tanggal_mulai')->nullable();

      $table->timestamp('tanggal_submit')->nullable();

      $table->enum('status', [
        'draft',
        'submitted',
        'validated'
      ])->default('draft');

      $table->timestamps();

      $table->unique(['periode_id', 'nim']);

      $table->index('periode_id');
      $table->index('nim');
      $table->index('status');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('tracer_respondens');
  }
};
