<?php

namespace App\Models\tracer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TracerOpsi extends Model
{
  protected $fillable = [
    'pertanyaan_id',
    'nilai',
    'label',
    'urutan',
    'aktif'
  ];

  protected $casts = [
    'aktif' => 'boolean'
  ];

  public function pertanyaan(): BelongsTo
  {
    return $this->belongsTo(
      TracerPertanyaan::class,
      'pertanyaan_id'
    );
  }


}
