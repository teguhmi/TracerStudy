<?php

namespace App\Console\Commands;

use App\Models\tracer\TracerResponden;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateTracerExportPddikti extends Command
{
  protected $signature = 'tracer:export-pddikti {tahun=2026}';

  protected $description = 'Export data v_tracer_pddikti ke tracer_export_pddikti';

  public function handle()
  {
    ini_set('memory_limit', '1024M');
    set_time_limit(0);

    $tahun = (int) $this->argument('tahun');

    $this->info('========================================');
    $this->info("EXPORT PDDIKTI TAHUN {$tahun}");
    $this->info('========================================');

    $totalResponden = TracerResponden::query()
      ->whereYear('tanggal_lulus', $tahun)
      ->count();

    $this->info('Total Responden : ' . number_format($totalResponden));

    $totalExport = 0;

    TracerResponden::query()
      ->whereYear('tanggal_lulus', $tahun)
      ->orderBy('id')
      ->chunkById(10, function ($rows) use (&$totalExport) {

        $payload = [];

        foreach ($rows as $responden) {

          $row = DB::selectOne("
                        SELECT *
                        FROM v_tracer_pddikti
                        WHERE nim = '{$responden->nim}'
                        LIMIT 1
                    ");

          if (!$row) {
            continue;
          }

          $data = (array) $row;

          unset($data['id']);

          $data['created_at'] = now();
          $data['updated_at'] = now();

          $payload[] = $data;
        }

        if (empty($payload)) {
          return;
        }

        $updateColumns = array_filter(
          array_keys($payload[0]),
          fn ($column) => !in_array(
            $column,
            [
              'nim',
              'created_at'
            ]
          )
        );

        DB::table('tracer_export_pddikti')->upsert(
          $payload,
          ['nim'],
          $updateColumns
        );

        $totalExport += count($payload);

        $this->info(
          'Diproses : ' .
          number_format($totalExport)
        );

        unset($payload);
      });

    $jumlah = DB::table('tracer_export_pddikti')->count();

    $this->info('Count Tabel : ' . $jumlah);
    $this->info('TotalExport : ' . $totalExport);

    $this->newLine();
    $this->info('========================================');
    $this->info('EXPORT SELESAI');
    $this->info('Total Export : ' . number_format($totalExport));
    $this->info('========================================');

    return self::SUCCESS;
  }
}
