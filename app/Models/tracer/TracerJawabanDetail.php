<?php

namespace App\Models\tracer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TracerJawabanDetail extends Model
{
  protected $table = 'tracer_jawaban_details';

  protected $fillable = [
    'jawaban_id',
    'pilihan',
  ];

  public function jawaban(): BelongsTo
  {
    return $this->belongsTo(
      TracerJawaban::class,
      'jawaban_id'
    );
  }
}
