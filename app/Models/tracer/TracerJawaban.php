<?php

namespace App\Models\tracer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TracerJawaban extends Model
{
  protected $fillable = [
    'responden_id',
    'pertanyaan_id',
    'kode_pertanyaan',
    'jawaban'
  ];

  public function responden(): BelongsTo
  {
    return $this->belongsTo(
      TracerResponden::class,
      'responden_id'
    );
  }

  public function details(): HasMany
  {
    return $this->hasMany(
      TracerJawabanDetail::class,
      'jawaban_id'
    );
  }
}
