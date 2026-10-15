<?php

namespace App\Models\tracer;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TracerLog extends Model
{
  protected $table = 'tracer_logs';

  protected $fillable = [
    'responden_id',
    'user_id',
    'aktivitas',
    'keterangan',
    'data_lama',
    'data_baru',
    'ip_address',
    'user_agent',
  ];

  protected $casts = [
    'data_lama' => 'array',
    'data_baru' => 'array',
  ];

  public function responden(): BelongsTo
  {
    return $this->belongsTo(
      TracerResponden::class,
      'responden_id'
    );
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(
      User::class,
      'user_id'
    );
  }
}
