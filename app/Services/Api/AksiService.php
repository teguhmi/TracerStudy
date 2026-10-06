<?php

namespace App\Services\Api;

use Illuminate\Support\Facades\DB;

class AksiService
{
    /**
     * Mengambil data dari database dbaksi.
     */
    public function getData()
    {
        $masa = '20262';
        $data = DB::connection('mariadb')
            ->table('t_yudisium')
            ->where('masa', $masa)
            ->where('alumni_synced', 0)
            ->limit(10)
            ->get();
        return $data;
    }

}