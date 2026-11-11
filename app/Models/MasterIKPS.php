<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterIKPS extends Model
{
  protected $table = 'master_ikps';

  protected $fillable = [
    'kode',
    'nama',
  ];
}
