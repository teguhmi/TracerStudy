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
        Schema::connection('pgsql')
            ->table('m_data_pribadi_alumni', function (Blueprint $table) {
                $table->boolean('sika_synced')->default(false);
                $table->timestamp('sika_synced_at')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql')
            ->table('m_data_pribadi_alumni', function (Blueprint $table) {
                $table->dropColumn([
                    'sika_synced',
                    'sika_synced_at',
                ]);
            });
    }
};
