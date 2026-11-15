<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('master_perguruan_tinggis', function (Blueprint $table) {
      $table->id();
      $table->string('kode', 10)->unique();
      $table->string('nama', 150)->index();
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('master_perguruan_tinggis');
  }
};
