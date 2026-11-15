<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::table('tracer_respondens', function (Blueprint $table) {

      $table->string('npwp', 30)->nullable()->after('nama');
      $table->string('email', 150)->nullable()->after('npwp');
      $table->string('no_hp', 30)->nullable()->after('email');
      $table->text('alamat_lengkap')->nullable()->after('no_hp');

      $table->unsignedBigInteger('negara_id')->nullable()->after('alamat_lengkap');
      $table->unsignedBigInteger('provinsi_id')->nullable()->after('negara_id');
      $table->unsignedBigInteger('kabupaten_id')->nullable()->after('provinsi_id');
    });
  }

  public function down(): void
  {
    Schema::table('tracer_respondens', function (Blueprint $table) {

      $table->dropColumn([
        'npwp',
        'email',
        'no_hp',
        'alamat',
        'alamat_lengkap',
        'negara_id',
        'provinsi_id',
        'kabupaten_id'
      ]);
    });
  }
};
