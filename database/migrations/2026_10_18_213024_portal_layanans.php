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
      Schema::create('portal_layanans', function (Blueprint $table) {
        $table->id();

        $table->string('nama');
        $table->string('slug')->unique();

        $table->string('icon')->nullable();
        $table->string('warna')->nullable();

        $table->text('deskripsi')->nullable();

        $table->string('url')->nullable();
        $table->longText('class')->nullable();
        $table->longText('text')->nullable();

        $table->boolean('is_external')
          ->default(false);

        $table->integer('urutan')
          ->default(0);

        $table->boolean('aktif')
          ->default(true);

        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
  public function down(): void
  {
    Schema::dropIfExists('portal_layanans');
  }
};
