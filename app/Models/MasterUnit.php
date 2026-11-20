<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterUnit extends Model
{
  protected $table = 'm_unit';

  protected $primaryKey = 'id';

  public $timestamps = false;

  protected $guarded = [];

  /**
   * Scope unit yang ditampilkan.
   */
  public function scopeTampil($query)
  {
    return $query->where('tampil', '1');
  }
}
