<?php

namespace App\Models\tracer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TracerProvinsi extends Model
{
  protected $table = 'tracer_provinsis';

  protected $fillable = [
    'negara_id',
    'kode',
    'nama',
  ];

  public function negara(): BelongsTo
  {
    return $this->belongsTo(
      TracerNegara::class,
      'negara_id'
    );
  }

  public function kotas(): HasMany
  {
    return $this->hasMany(
      TracerKota::class,
      'provinsi_id'
    );
  }
}
