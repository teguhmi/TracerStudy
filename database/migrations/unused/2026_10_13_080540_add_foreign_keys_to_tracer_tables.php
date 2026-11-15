<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    /*
    |--------------------------------------------------------------------------
    | tracer_pertanyaans
    |--------------------------------------------------------------------------
    */
    Schema::table('tracer_pertanyaans', function (Blueprint $table) {

      if (!Schema::hasColumn('tracer_pertanyaans', 'section_id')) {
        $table->foreignId('section_id')
          ->nullable()
          ->after('id')
          ->constrained('tracer_sections')
          ->nullOnDelete();
      }

      $table->foreign('kategori_id')
        ->references('id')
        ->on('tracer_kategoris')
        ->nullOnDelete();
    });

    /*
    |--------------------------------------------------------------------------
    | tracer_opsis
    |--------------------------------------------------------------------------
    */
    Schema::table('tracer_opsis', function (Blueprint $table) {

      $table->foreign('pertanyaan_id')
        ->references('id')
        ->on('tracer_pertanyaans')
        ->cascadeOnDelete();
    });

    /*
    |--------------------------------------------------------------------------
    | tracer_respondens
    |--------------------------------------------------------------------------
    */
    Schema::table('tracer_respondens', function (Blueprint $table) {

      $table->foreign('periode_id')
        ->references('id')
        ->on('tracer_periodes')
        ->cascadeOnDelete();
    });

    /*
    |--------------------------------------------------------------------------
    | tracer_jawabans
    |--------------------------------------------------------------------------
    */

    if (!Schema::hasColumn('tracer_jawabans', 'pertanyaan_id')) {

      Schema::table('tracer_jawabans', function (Blueprint $table) {

        $table->foreignId('pertanyaan_id')
          ->nullable()
          ->after('responden_id');
      });
    }

    Schema::table('tracer_jawabans', function (Blueprint $table) {

      $table->foreign('responden_id')
        ->references('id')
        ->on('tracer_respondens')
        ->cascadeOnDelete();

      $table->foreign('pertanyaan_id')
        ->references('id')
        ->on('tracer_pertanyaans')
        ->nullOnDelete();
    });

    /*
    |--------------------------------------------------------------------------
    | tracer_jawaban_details
    |--------------------------------------------------------------------------
    */
    Schema::table('tracer_jawaban_details', function (Blueprint $table) {

      $table->foreign('jawaban_id')
        ->references('id')
        ->on('tracer_jawabans')
        ->cascadeOnDelete();
    });

    /*
    |--------------------------------------------------------------------------
    | lokasi
    |--------------------------------------------------------------------------
    */
//    Schema::table('tracer_provinsis', function (Blueprint $table) {
//
//      $table->foreign('negara_id')
//        ->references('id')
//        ->on('tracer_negaras')
//        ->cascadeOnDelete();
//    });

//    Schema::table('tracer_kotas', function (Blueprint $table) {
//
//      $table->foreign('provinsi_id')
//        ->references('id')
//        ->on('tracer_provinsis')
//        ->cascadeOnDelete();
//    });

    /*
    |--------------------------------------------------------------------------
    | tracer_logs
    |--------------------------------------------------------------------------
    */
    Schema::table('tracer_logs', function (Blueprint $table) {

      $table->foreign('responden_id')
        ->references('id')
        ->on('tracer_respondens')
        ->cascadeOnDelete();
    });
  }

  public function down(): void
  {
    Schema::table('tracer_logs', function (Blueprint $table) {
      $table->dropForeign(['responden_id']);
    });

    Schema::table('tracer_kotas', function (Blueprint $table) {
      $table->dropForeign(['provinsi_id']);
    });

    Schema::table('tracer_provinsis', function (Blueprint $table) {
      $table->dropForeign(['negara_id']);
    });

    Schema::table('tracer_jawaban_details', function (Blueprint $table) {
      $table->dropForeign(['jawaban_id']);
    });

    Schema::table('tracer_jawabans', function (Blueprint $table) {
      $table->dropForeign(['responden_id']);
      $table->dropForeign(['pertanyaan_id']);
    });

    Schema::table('tracer_respondens', function (Blueprint $table) {
      $table->dropForeign(['periode_id']);
    });

    Schema::table('tracer_opsis', function (Blueprint $table) {
      $table->dropForeign(['pertanyaan_id']);
    });

    Schema::table('tracer_pertanyaans', function (Blueprint $table) {
      $table->dropForeign(['kategori_id']);

      if (Schema::hasColumn('tracer_pertanyaans', 'section_id')) {
        $table->dropForeign(['section_id']);
      }
    });
  }
};
