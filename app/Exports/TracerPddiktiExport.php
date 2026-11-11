<?php

namespace App\Console\Commands;

use App\Models\tracer\TracerResponden;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateTracerExportPddikti extends Command
{
  protected $signature = 'tracer:export-pddikti
                            {--tahun=}
                            {--chunk=1000}';

  protected $description = 'Generate tabel tracer_export_pddikti';

  public function handle(): int
  {
    $tahun = $this->option('tahun');
    $chunk = (int) $this->option('chunk');

    $query = TracerResponden::query()
      ->select('id', 'nim');

    if ($tahun) {
      $query->whereYear('tanggal_lulus', $tahun);
    }

    $total = (clone $query)->count();

    $this->info("Total responden: {$total}");

    $bar = $this->output->createProgressBar($total);

    $query
      ->orderBy('id')
      ->chunkById($chunk, function ($rows) use ($bar) {

        $nims = $rows
          ->pluck('nim')
          ->filter()
          ->values()
          ->all();

        if (empty($nims)) {
          return;
        }

        $exports = DB::table('v_tracer_pddikti')
          ->whereIn('nim', $nims)
          ->get();

        $payload = [];

        foreach ($exports as $row) {

          $payload[] = [
            'nim' => $row->nim,

            'tahun_lulus' => $row->tahun_lulus ?? null,
            'kode_pt' => $row->kode_pt ?? null,
            'kode_prodi' => $row->kode_prodi ?? null,

            'nama' => $row->nama ?? null,
            'telepon' => $row->telepon ?? null,
            'email' => $row->email ?? null,
            'nik' => $row->nik ?? null,
            'npwp' => $row->npwp ?? null,

            'data_export' => json_encode(
              $row,
              JSON_UNESCAPED_UNICODE
            ),

            'created_at' => now(),
            'updated_at' => now(),
          ];
        }

        if (!empty($payload)) {

          DB::table('tracer_export_pddikti')
            ->upsert(
              $payload,
              ['nim'], // unique key
              [
                'tahun_lulus',
                'kode_pt',
                'kode_prodi',
                'nama',
                'telepon',
                'email',
                'nik',
                'npwp',
                'data_export',
                'updated_at'
              ]
            );
        }

        $bar->advance(count($rows));
      });

    $bar->finish();

    $this->newLine(2);
    $this->info('Selesai');

    return self::SUCCESS;
  }
}
