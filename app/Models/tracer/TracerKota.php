<?php

namespace App\Models\tracer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TracerKota extends Model
{
  protected $table = 'tracer_kotas';

  protected $fillable = [
    'provinsi_id',
    'kode',
    'nama',
  ];

  public function provinsi(): BelongsTo
  {
    return $this->belongsTo(
      TracerProvinsi::class,
      'provinsi_id'
    );
  }
}
