<?php

namespace App\Models\tracer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TracerPeriode extends Model
{
//  protected $table = 'tracer_periodes';

  protected $fillable = [
    'nama_periode',
    'tahun_mulai',
    'tahun_selesai',
    'aktif',
  ];

  protected $casts = [
    'aktif' => 'boolean',
  ];

  public function respondens(): HasMany
  {
    return $this->hasMany(
      TracerResponden::class,
      'periode_id'
    );
  }
}
