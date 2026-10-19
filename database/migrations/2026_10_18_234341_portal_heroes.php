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
    Schema::create('portal_heroes', function (Blueprint $table) {
      $table->id();

      $table->string('badge')->nullable();

      $table->string('title');

      $table->string('subtitle')->nullable();

      $table->text('description')->nullable();

      $table->string('button_text')->nullable();

      $table->string('button_url')->nullable();

      $table->string('image')->nullable();

      $table->integer('urutan')->default(0);

      $table->boolean('is_active')->default(false);

      $table->timestamp('publish_start')->nullable();

      $table->timestamp('publish_end')->nullable();

      $table->timestamps();

      $table->index('is_active');
      $table->index('urutan');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('portal_heroes');
  }
};
