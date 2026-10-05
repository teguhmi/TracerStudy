<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DataPribadiAlumni extends Model
{


    protected $connection = 'pgsql';

    protected $table = 'm_data_pribadi_alumni';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';
    public function skRektor()
    {
        return $this->belongsTo(
            SkRektor::class,
            'nomor_sk_rektor',
            'nomor_sk_rektor'
        );
    }
    protected function tempatLahirFormat(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->tempat_lahir)) {
                    return '-';
                }

                return Str::title(
                    Str::lower(trim($this->tempat_lahir))
                );
            }
        );
    }
    protected function tempatTanggalLahir(): Attribute
    {
        return Attribute::make(
            get: function () {
                $tempat = $this->tempat_lahir_format;
                $tanggal = $this->tanggal_lahir_format;

                if ($tempat === '-' && $tanggal === '-') {
                    return '-';
                }

                if ($tempat === '-') {
                    return $tanggal;
                }

                if ($tanggal === '-') {
                    return $tempat;
                }

                return "{$tempat}, {$tanggal}";
            }
        );
    }

    protected function tanggalLahirFormat(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->tanggal_lahir)) {
                    return '-';
                }
                $tanggal = trim($this->tanggal_lahir);
                $formats = [
                    'd/m/Y',
                    'd-m-Y',
                    'Y-m-d',
                ];

                foreach ($formats as $format) {
                    try {
                        return Carbon::createFromFormat($format, $tanggal)
                            ->locale('id')
                            ->translatedFormat('d F Y');
                    } catch (\Exception $e) {
                        // Coba format berikutnya
                    }
                }

                return '-';
            }
        );
    }

}
