<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class SkRektor extends Model
{
  protected $connection = 'pgsql';

  protected $table = 'm_sk_rektor';

  public $timestamps = false;

  protected function tanggalSkFormat(): Attribute
  {
    return Attribute::make(
      get: fn () => !empty($this->tanggal_sk)
        ? Carbon::parse($this->tanggal_sk)
          ->locale('id')
          ->translatedFormat('d F Y')
        : '-'
    );
  }
}
