<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('tracer_logs', function (Blueprint $table) {

      $table->id();

      // Tanpa Foreign Key
      $table->unsignedBigInteger('responden_id')->nullable();

      $table->unsignedBigInteger('user_id')->nullable();

      $table->string('aktivitas', 100);

      $table->text('keterangan')->nullable();

      $table->json('data_lama')->nullable();

      $table->json('data_baru')->nullable();

      $table->ipAddress('ip_address')->nullable();

      $table->text('user_agent')->nullable();

      $table->timestamps();

      $table->index('responden_id');
      $table->index('user_id');
      $table->index('aktivitas');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('tracer_logs');
  }
};
