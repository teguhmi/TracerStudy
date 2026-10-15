<?php

namespace App\Models\tracer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TracerPertanyaan extends Model
{

  protected $fillable = [
    'section_id',
    'kategori_id',
    'kode',
    'parent_kode',
    'pertanyaan',
    'placeholder',
    'help_text',
    'jenis',
    'wajib',
    'tampil_jika',
    'urutan',
    'aktif'
  ];

  protected $casts = [
    'wajib' => 'boolean',
    'aktif' => 'boolean',
    'tampil_jika' => 'array',
  ];

  public function section(): BelongsTo
  {
    return $this->belongsTo(
      TracerSection::class,
      'section_id'
    );
  }

  public function kategori(): BelongsTo
  {
    return $this->belongsTo(
      TracerKategori::class,
      'kategori_id'
    );
  }

  public function opsi(): HasMany
  {
    return $this->hasMany(
      TracerOpsi::class,
      'pertanyaan_id'
    )->orderBy('urutan');
  }

  public function parent(): BelongsTo
  {
    return $this->belongsTo(
      self::class,
      'parent_kode',
      'kode'
    );
  }

  public function children(): HasMany
  {
    return $this->hasMany(
      self::class,
      'parent_kode',
      'kode'
    );
  }
}

