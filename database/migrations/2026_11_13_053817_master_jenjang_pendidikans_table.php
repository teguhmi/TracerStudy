<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('master_jenjang_pendidikans', function (Blueprint $table) {
      $table->id();                       // Menyimpan ID Dikti (20, 22, 30, dst.)
      $table->string('nama', 30);         // D1, D3, S1, S2, Profesi, dst.
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('master_jenjang_pendidikans');
  }
};
