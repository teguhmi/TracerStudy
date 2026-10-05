<?php

namespace App\Services\Api;

use App\Models\DataPribadiAlumni;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AlumniService
{
    public function current(): DataPribadiAlumni
    {
        // Jika login sebagai mahasiswa/alumni
        $nim = '017290654';
//        if (session()->has('nim')) {
//            $nim = session('nim');
//        }
// Jika pegawai, NIM harus diberikan dari controller
        abort_if(
            empty($nim),
            400,
            'NIM mahasiswa tidak tersedia.'
        );

        return $this->getByNim($nim);
    }


    public function getByNim(string $nim): DataPribadiAlumni
    {
        return DataPribadiAlumni::with([
            'skRektor',
        ])
            ->where('nim', $nim)
            ->firstOrFail();
    }

    public function nim(): string
    {
        return $this->current()->nim;
    }

    public function masa_yudisium(): ?string
    {
        return $this->current()->masa_yudisium;
    }

    public function fotoPath(?DataPribadiAlumni $dpAlumni = null): string
    {
        $dpAlumni ??= $this->current();
        return "alumni/foto-ijazah/{$dpAlumni->masa_yudisium}/{$dpAlumni->nim}.jpg";
    }


    public function simpanFotoIjazah(UploadedFile $file): string
    {
        $fotoPath = $this->fotoPath();

        return $file->storeAs(
            dirname($fotoPath),
            basename($fotoPath),
            'public'
        );
    }


    public function fotoIjazah(): ?string
    {
        $fotoPath = $this->fotoPath();

        return Storage::disk('public')->exists($fotoPath)
            ? Storage::disk('public')->url($fotoPath)
            : null;
    }

    public function fotoIjazahAda(): bool
    {
        return Storage::disk('public')->exists(
            $this->fotoPath()
        );
    }
}
