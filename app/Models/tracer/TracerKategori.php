<?php

namespace App\Models\tracer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TracerKategori extends Model
{
  protected $table = 'tracer_kategoris';

  protected $fillable = [
    'kode',
    'nama',
    'urutan',
  ];

  public function pertanyaans(): HasMany
  {
    return $this->hasMany(
      TracerPertanyaan::class,
      'kategori_id'
    );
  }
}
