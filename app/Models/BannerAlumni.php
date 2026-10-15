<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerAlumni extends Model
{
  protected $table = 'banner_alumni';

  protected $fillable = [
    'judul',
    'subjudul',
    'gambar',
    'url',
    'urutan',
    'aktif'
  ];

}
