<?php

namespace App\Models\tracer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TracerNegara extends Model
{
  protected $table = 'tracer_negaras';

  protected $fillable = [
    'kode',
    'nama',
  ];

  public function provinsis(): HasMany
  {
    return $this->hasMany(
      TracerProvinsi::class,
      'negara_id'
    );
  }
}
