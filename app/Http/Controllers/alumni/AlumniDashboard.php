<?php

namespace App\Http\Controllers\alumni;

use App\Http\Controllers\Controller;

use App\Services\Api\AlumniService;
use App\Services\Api\RplApiService;
use App\Services\Api\SrsApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlumniDashboard extends Controller
{

  public function __construct(
    protected SrsApiService $srsApi,
    protected RplApiService $rplApi,
    protected AlumniService $alumniService)

  {}

    public function index()
    {
        $dpAlumni = $this->alumniService->current();

        $nim  = $dpAlumni->nim;
        $masa = $dpAlumni->masa_yudisium;

        $rpl = $this->rplApi->getRPL($nim);

        $fotoPath = "alumni/foto-ijazah/{$masa}/{$nim}.jpg";

        $fotoIjazah = Storage::disk('public')->exists($fotoPath)
            ? Storage::disk('public')->url($fotoPath)
            : null;

        return view(
            'content.pages.alumni-dashboard.AlumniDashboard',
            compact('dpAlumni', 'rpl', 'fotoIjazah')
        );
    }

//  public function profile($nim)
//  {
//    $rpl = $this->rplApi->getRPL($nim);
//    $dpAlumni = DataPribadiAlumni::with('skRektor')
//      ->where('nim', $nim)
//      ->firstOrFail();
//    return view('content.pages.alumni-dashboard.AlumniDashboard', compact(
//      'dpAlumni',
//      'rpl'
//    ));
//  }
  public function uploadFotoIjazah(Request $request)
  {
    // =========================================================
    // VALIDASI
    // =========================================================
    $request->validate([
      'foto_ijazah' => [
        'required',
        'file',
        'image',
        'mimes:jpg,jpeg',
        'max:1024',
        'dimensions:width=600,height=800',
      ],
    ]);

    // =========================================================
    // SIMPAN FILE
    // =========================================================
    $path = $this->alumniService->simpanFotoIjazah(
      $request->file('foto_ijazah')
    );

    // =========================================================
    // RESPONSE
    // =========================================================
    return response()->json([
      'success' => true,
      'message' => 'Foto berhasil disimpan.',
      'path' => $path,
      'url' => $this->alumniService->fotoIjazah(),
    ]);
  }
}
