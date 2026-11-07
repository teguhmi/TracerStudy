<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class ImportTracerJawaban extends Command
{
  protected $signature = 'tracer:import-jawaban';

  protected $description = 'Import tracer_dikti_v1 ke tracer_respondens dan tracer_jawabans';

  public function handle(): int
  {
    ini_set('memory_limit', '1024M');
    set_time_limit(0);

    $this->info('====================================');
    $this->info('MULAI IMPORT');
    $this->info('====================================');

    /*
    |--------------------------------------------------------------------------
    | IMPORT RESPONDEN
    |--------------------------------------------------------------------------
    */
    $this->info('Import responden...');

    DB::table('tracer_dikti_v1')
      ->orderBy('nim')
      ->chunk(1000, function ($rows) {

        $payload = [];

        foreach ($rows as $row) {

          try {

            $nim     = trim((string) ($row->nim ?? ''));
            $nama    = trim((string) ($row->nama_mahasiswa ?? ''));
            $email   = trim((string) ($row->email ?? ''));
            $telepon = trim((string) ($row->telepon ?? ''));
            $npwp    = trim((string) ($row->npwp ?? ''));

            $payload[] = [
              'nim'        => $nim,
              'nama'       => $nama ?: null,
              'email'      => $email ?: null,
              'telepon'    => $telepon ?: null,
              'npwp'       => $npwp ?: null,
              'created_at' => now(),
              'updated_at' => now(),
            ];
          } catch (Throwable $e) {

            $this->error(
              'Error responden NIM '
              . ($row->nim ?? '-')
              . ' : '
              . $e->getMessage()
            );

            continue;
          }
        }

        if (!empty($payload)) {

          try {

            DB::table('tracer_respondens')->upsert(
              $payload,
              ['nim'],
              [
                'nama',
                'email',
                'telepon',
                'npwp',
                'updated_at',
              ]
            );
          } catch (Throwable $e) {

            $this->error(
              'Gagal upsert responden : '
              . $e->getMessage()
            );
          }
        }
      });

    $this->info('Import responden selesai');

    /*
    |--------------------------------------------------------------------------
    | MAPPING PERTANYAAN
    |--------------------------------------------------------------------------
    */
    $pertanyaanMap = DB::table('tracer_pertanyaans')
      ->select(
        'id',
        'kode',
        'jenis'
      )
      ->get()
      ->keyBy(function ($item) {
        return strtoupper($item->kode);
      });

    /*
    |--------------------------------------------------------------------------
    | Mapping khusus field sumber
    |--------------------------------------------------------------------------
    */
    $fieldToKode = [
      'nik'  => 'BIO01',
      'npwp' => 'BIO02',
      'f506' => 'F510',
    ];

    $kodeToField = array_flip($fieldToKode);

    $totalJawaban = 0;

    /*
    |--------------------------------------------------------------------------
    | IMPORT JAWABAN
    |--------------------------------------------------------------------------
    */
    $this->info('Import jawaban...');

    DB::table('tracer_dikti_v1')
      ->orderBy('nim')
      ->chunk(500, function (
        $rows
      ) use (
        $pertanyaanMap,
        $kodeToField,
        &$totalJawaban
      ) {

        $nims = collect($rows)
          ->pluck('nim')
          ->filter()
          ->map(fn($x) => trim((string) $x))
          ->unique()
          ->values()
          ->toArray();

        $respondenMap = DB::table('tracer_respondens')
          ->whereIn('nim', $nims)
          ->pluck('id', 'nim')
          ->toArray();

        $payload = [];

        foreach ($rows as $row) {

          try {

            $nim = trim((string) ($row->nim ?? ''));

            if (!isset($respondenMap[$nim])) {
              continue;
            }

            $respondenId = $respondenMap[$nim];

            /*
            |--------------------------------------------------------------------------
            | Normalisasi seluruh kolom sumber
            |--------------------------------------------------------------------------
            */
            $rowData = [];

            foreach ((array) $row as $key => $val) {

              $key = strtolower($key);

              if ($val === null) {
                $rowData[$key] = null;
                continue;
              }

              $val = trim((string) $val);

              $rowData[$key] = $val === ''
                ? null
                : $val;
            }

            /*
            |--------------------------------------------------------------------------
            | Loop seluruh pertanyaan
            |--------------------------------------------------------------------------
            */
            foreach ($pertanyaanMap as $kode => $pertanyaan) {

              $field = $kodeToField[$kode]
                ?? strtolower($kode);

              $value = $rowData[$field] ?? null;

              /*
              |--------------------------------------------------------------------------
              | Checkbox => JSON
              |--------------------------------------------------------------------------
              */
              if ($pertanyaan->jenis === 'checkbox') {

                if ($value !== null) {

                  $items = preg_split(
                    '/[,;|]/',
                    (string) $value
                  );

                  $items = array_values(
                    array_filter(
                      array_map(
                        'trim',
                        $items
                      ),
                      fn($item) => $item !== ''
                    )
                  );

                  $value = empty($items)
                    ? null
                    : json_encode(
                      $items,
                      JSON_UNESCAPED_UNICODE
                    );
                }
              }

              $payload[] = [
                'responden_id'    => $respondenId,
                'pertanyaan_id'   => $pertanyaan->id,
                'kode_pertanyaan' => $kode,
                'jawaban'         => $value,
                'created_at'      => now(),
                'updated_at'      => now(),
              ];

              if (count($payload) >= 1000) {

                try {

                  DB::table('tracer_jawabans')->upsert(
                    $payload,
                    [
                      'responden_id',
                      'pertanyaan_id',
                    ],
                    [
                      'jawaban',
                      'updated_at',
                    ]
                  );

                  $totalJawaban += count($payload);

                  $this->line(
                    'Jawaban : '
                    . number_format($totalJawaban)
                  );
                } catch (Throwable $e) {

                  $this->error(
                    'Gagal upsert batch : '
                    . $e->getMessage()
                  );
                }

                $payload = [];
              }
            }
          } catch (Throwable $e) {

            $this->error(
              'Error NIM '
              . ($row->nim ?? '-')
              . ' : '
              . $e->getMessage()
            );

            continue;
          }
        }

        /*
        |--------------------------------------------------------------------------
        | Flush sisa payload
        |--------------------------------------------------------------------------
        */
        if (!empty($payload)) {

          try {

            DB::table('tracer_jawabans')->upsert(
              $payload,
              [
                'responden_id',
                'pertanyaan_id',
              ],
              [
                'jawaban',
                'updated_at',
              ]
            );

            $totalJawaban += count($payload);

            $this->line(
              'Jawaban : '
              . number_format($totalJawaban)
            );
          } catch (Throwable $e) {

            $this->error(
              'Gagal upsert batch akhir : '
              . $e->getMessage()
            );
          }
        }

        unset(
          $payload,
          $respondenMap,
          $nims
        );
      });

    $this->newLine();
    $this->info('====================================');
    $this->info('IMPORT SELESAI');
    $this->info(
      'Total Jawaban : '
      . number_format($totalJawaban)
    );
    $this->info('====================================');

    return self::SUCCESS;
  }
}
