<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PortalHero extends Model
{
  protected $table = 'portal_heroes';

  protected $fillable = [
    'badge',
    'title',
    'subtitle',
    'description',
    'button_text',
    'button_url',
    'image',
    'urutan',
    'is_active',
    'publish_start',
    'publish_end',
  ];

  protected $casts = [
    'is_active'     => 'boolean',
    'publish_start' => 'datetime',
    'publish_end'   => 'datetime',
  ];

  /**
   * Scope: Hero Aktif
   */
  public function scopeActive(Builder $query): Builder
  {
    return $query->where('is_active', true);
  }

  /**
   * Scope: Hero yang sedang tayang
   */
  public function scopePublished(Builder $query): Builder
  {
    return $query
      ->where(function ($q) {
        $q->whereNull('publish_start')
          ->orWhere('publish_start', '<=', now());
      })
      ->where(function ($q) {
        $q->whereNull('publish_end')
          ->orWhere('publish_end', '>=', now());
      });
  }

  /**
   * Scope: Urut berdasarkan urutan
   */
  public function scopeOrdered(Builder $query): Builder
  {
    return $query->orderBy('urutan');
  }

  /**
   * Ambil URL gambar
   */
  public function getImageUrlAttribute(): ?string
  {
    if (empty($this->image)) {
      return null;
    }

    return asset($this->image);
  }

  /**
   * Hero yang tampil saat ini
   */
  public static function current(): ?self
  {
    return static::query()
      ->active()
      ->published()
      ->ordered()
      ->first();
  }
}
