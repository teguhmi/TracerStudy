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
      Schema::create('tracer_provinsis', function (Blueprint $table) {

        $table->id();

        $table->string('negara_id', 10)->nullable();

        $table->string('kode', 20)->unique();

        $table->string('nama');

        $table->timestamps();

        $table->index('negara_id');
        $table->index('kode');
        $table->index('nama');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
