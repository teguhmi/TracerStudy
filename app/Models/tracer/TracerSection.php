<?php

namespace App\Models\tracer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TracerSection extends Model
{
  protected $table = 'tracer_sections';

  protected $fillable = [
    'kode',
    'nama',
    'deskripsi',
    'urutan',
    'aktif',
  ];

  protected $casts = [
    'aktif' => 'boolean',
  ];

  public function pertanyaans(): HasMany
  {
    return $this->hasMany(
      TracerPertanyaan::class,
      'section_id'
    )->orderBy('urutan');
  }


}
