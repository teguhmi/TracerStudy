<?php

namespace App\Console\Commands;

use App\Models\query\QueryAKSIModel;
use App\Models\srs\QueryAKSIController;
use App\Models\srs\QuerySRSController;
use Carbon\Carbon;
use Illuminate\Console\Command;

class update_dp_dari_5g extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'updatedp:cron {masa=20201}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Update data pribadi (DP) mahasiswa pada tabel yudisium';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    $masa = $this->argument('masa');
    $query = QueryAKSIModel::get_nim_masa($masa);

    $this->info("Mulai proses (Masa {$masa}): " . Carbon::now()->format('d-m-Y H:i:s'));
    $total = count($query);
    $this->info("Total data: {$total}");

    if ($total === 0) {
      $this->warn('Tidak ada data untuk diproses.');
      return 0;
    }

    $bar = $this->output->createProgressBar($total);
    $bar->start();

    $success = 0;
    $failed = 0;
    $notFound = 0;

    foreach ($query as $items) {
      $nim = $items->nim;

      try {
        $dp = QuerySRSController::getdpbynim($nim);

        if ($dp) {
          $data_array = [
            'jenis_kelamin'      => $dp['jenis_kelamin'] ?? null,
            'nama_singkat_ps'    => $dp['nama_singkat_program_studi'] ?? null,
            'kode_prodi_dikti'   => $dp['kode_prodi_dikti'] ?? null,
            'nama_prodi_dikti'   => $dp['nama_prodi_dikti'] ?? null,
            'kode_fakultas'      => $dp['kode_fakultas'] ?? null,
            'nama_fakultas'      => $dp['nama_fakultas'] ?? null,
            'singkatan'          => $dp['singkatan_fakultas'] ?? null,
            'kode_jenjang'       => $dp['kode_jenjang'] ?? null,
            'nama_jenjang'       => $dp['jenjang_program_studi'] ?? null,
            'kode_jenis_program' => $dp['kode_jenis_program'] ?? null,
            'nama_jenis_program' => $dp['jenis_program'] ?? null,
            'kode_upbjj'         => $dp['kode_upbjj'] ?? null,
            'nama_upbjj'         => isset($dp['nama_upbjj']) ? strtoupper($dp['nama_upbjj']) : null,
            'kode_kabko'         => $dp['kode_kabko'] ?? null,
            'nama_kabko'         => $dp['nama_kabko'] ?? null,
            'pokjar'             => $dp['pokjar'] ?? null,
            'agama'              => $dp['nama_agama'] ?? null,
          ];

          QueryAKSIController::update_t_yudisium($nim, $data_array);
          $success++;
        } else {
          $notFound++;
        }
      } catch (\Exception $e) {
        $this->newLine();
        $this->error("Error NIM {$nim}: " . $e->getMessage());
        $failed++;
      }

      $bar->advance();
    }

    $bar->finish();
    $this->newLine(2);
    $this->info('Selesai.');
    $this->info("Sukses: {$success}, Tidak ditemukan: {$notFound}, Gagal: {$failed}");
    $this->info('Selesai proses: ' . Carbon::now()->format('d-m-Y H:i:s'));

    return 0;
  }
}
