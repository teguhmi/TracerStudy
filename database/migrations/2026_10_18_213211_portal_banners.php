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
      Schema::create('portal_banners', function (Blueprint $table) {
        $table->id();

        $table->string('judul');
        $table->string('subjudul')->nullable();

        $table->text('deskripsi')->nullable();

        $table->string('gambar')->nullable();

        $table->string('button_text')->nullable();
        $table->string('button_url')->nullable();

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
    Schema::dropIfExists('portal_banners');
  }
};
