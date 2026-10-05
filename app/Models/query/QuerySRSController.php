<?php

namespace App\Models\query;

use Illuminate\Database\Eloquent\Model;

class QuerySRSController extends Model
{
    public static function get_YudisiumbyNIM($nim)
    {

        $sql = "SELECT * FROM t_yudisium as a where a.nim = '$nim'";
        $results = DB::connection(self::$db)
            ->select($sql);
        return $results;

    }
}
