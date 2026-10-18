<?php

namespace App\Models\tracer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TracerResponden extends Model
{
  protected $table = 'tracer_respondens';

  protected $fillable = [
    'periode_id',
    'nim',
    'nama',
    'status',
    'tanggal_lulus',
    'tanggal_mulai',
    'tanggal_submit',
    'status',
  ];

  protected $casts = [
//    'tanggal_lulus' => 'date',
//    'tanggal_mulai' => 'datetime',
//    'tanggal_submit' => 'datetime',
  ];

  public function periode(): BelongsTo
  {
    return $this->belongsTo(
      TracerPeriode::class,
      'periode_id'
    );
  }

  public function jawabans(): HasMany
  {
    return $this->hasMany(
      TracerJawaban::class,
      'responden_id'
    );
  }

  public function logs(): HasMany
  {
    return $this->hasMany(
      TracerLog::class,
      'responden_id'
    );
  }

  public function nilai(string $kode): ?string
  {
    return optional(
      $this->jawabans
        ->where('kode_pertanyaan', $kode)
        ->first()
    )->jawaban;
  }
}
