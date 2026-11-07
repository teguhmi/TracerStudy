@extends('_include._template_menu')

@section('content')

  <div class="container-fluid">

    <div class="card shadow-sm mb-4">

      <div class="card-header">
        <h5 class="mb-0">
          Laporan Ringkasan Tracer Study
        </h5>
      </div>

      <div class="card-body">
        <div class="row">

          <div class="col-md-4">
            <label class="form-label fw-bold">
              Tahun Lulus
            </label>

            <select
              id="tahun_lulus"
              name="tahun_lulus"
              class="form-select">
              <option value="">
                Memuat data...
              </option>
            </select>
          </div>

          <div class="col-md-4">
            <label class="form-label fw-bold">
              Jenis Laporan
            </label>

            <select
              id="jenis_laporan"
              name="jenis_laporan"
              class="form-select">

              <option value="fakultas">
                Berdasarkan Fakultas
              </option>

              <option value="upbjj">
                Berdasarkan UT Daerah
              </option>

              <option value="fakultas_upbjj">
                Fakultas per UT Daerah
              </option>

            </select>
          </div>

          <div class="col-md-4 d-flex align-items-end gap-2">
            <button
              type="button"
              id="btnTampilkan"
              class="btn btn-primary">
              <i class="bx bx-search"></i>
              Tampilkan
            </button>

            <button
              type="button"
              id="btnReset"
              class="btn btn-secondary">

              Reset

            </button>
          </div>

        </div>
      </div>
    </div>

    <div id="hasilLaporan"></div>

  </div>

@endsection

@section('style')
  <style>

    .header-biru th{
      background:#1f4e79 !important;
      color:#fff !important;
      border-color:#1f4e79 !important;
      text-align:center;
      vertical-align:middle;
    }

    .table td,
    .table th{
      white-space:nowrap;
    }

  </style>
@endsection

@section('script')
  <script>
    document.addEventListener('DOMContentLoaded', () => {

      const selectTahun  = document.getElementById('tahun_lulus');
      const selectJenis  = document.getElementById('jenis_laporan');
      const btnTampilkan = document.getElementById('btnTampilkan');
      const btnReset     = document.getElementById('btnReset');
      const hasilLaporan = document.getElementById('hasilLaporan');

      loadTahunLulus();

      btnTampilkan?.addEventListener('click', loadLaporan);

      btnReset?.addEventListener('click', () => {
        selectTahun.value = '';
        selectJenis.value = 'fakultas';
        hasilLaporan.innerHTML = '';
      });

      function loadTahunLulus() {

        fetch("{{ route('laporan.getTahunLulus') }}")
          .then(response => response.json())
          .then(data => {

            let html =
              '<option value="">-- Pilih Tahun Lulus --</option>';

            data.forEach(tahun => {
              html += `
                        <option value="${tahun}">
                            ${tahun}
                        </option>
                    `;
            });

            selectTahun.innerHTML = html;
          })
          .catch(error => {

            console.error(error);

            selectTahun.innerHTML =
              '<option value="">Gagal memuat data</option>';
          });
      }

      function loadLaporan() {

        const tahun = selectTahun.value;
        const jenis = selectJenis.value;

        if (!tahun) {
          alert('Pilih tahun lulus terlebih dahulu');
          return;
        }

        hasilLaporan.innerHTML = `
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    Memuat data...
                </div>
            </div>
        `;

        fetch(
          `{{ route('laporan.tracerRingkasan.data') }}?tahun_lulus=${tahun}&jenis=${jenis}`
        )
          .then(response => response.json())
          .then(data => {
            console.log('DATA:', data);
            if (jenis === 'upbjj') {
              renderTableUPBJJ(data, tahun);
            } else if (jenis === 'fakultas_upbjj') {
              renderTableFakultasUPBJJ(data, tahun);
            } else {
              renderTableFakultas(data, tahun);
            }

          })
          .catch(error => {

            console.error(error);

            hasilLaporan.innerHTML = `
                <div class="alert alert-danger">
                    Gagal memuat data
                </div>
            `;
          });
      }

      /**
       * LAPORAN FAKULTAS
       */
      function renderTableFakultas(data, tahun) {

        if (!data.length) {

          hasilLaporan.innerHTML = `
                <div class="alert alert-warning">
                    Data tidak ditemukan.
                </div>
            `;
          return;
        }

        let html = `
            <div class="card shadow-sm">
                <div class="card-body">

                    <h4 class="mb-3">
                        Ringkasan Tracer Tahun ${tahun}
                    </h4>

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped">

                            <thead>
                                <tr class="header-biru">
                                    <th>Fakultas</th>
                                    <th>Program Studi</th>
                                    <th>Lulusan</th>
                                    <th>Sudah Isi</th>
                                    <th>Belum Isi</th>
                                    <th>%</th>
                                </tr>
                            </thead>

                            <tbody>
        `;

        let fakultasAktif = '';

        let subtotalLulusan = 0;
        let subtotalSudah   = 0;
        let subtotalBelum   = 0;

        data.forEach(row => {

          if (fakultasAktif !== row.fakultas) {

            if (fakultasAktif !== '') {

              const persenSubtotal =
                subtotalLulusan > 0
                  ? ((subtotalSudah * 100) / subtotalLulusan).toFixed(1)
                  : 0;

              html += `
                        <tr class="table-warning fw-bold">

                            <td></td>

                            <td>
                                Subtotal ${fakultasAktif}
                            </td>

                            <td class="text-center">
                                ${subtotalLulusan.toLocaleString('id-ID')}
                            </td>

                            <td class="text-center">
                                ${subtotalSudah.toLocaleString('id-ID')}
                            </td>

                            <td class="text-center">
                                ${subtotalBelum.toLocaleString('id-ID')}
                            </td>

                            <td class="text-center">
                                ${persenSubtotal}%
                            </td>

                        </tr>
                    `;
            }

            fakultasAktif  = row.fakultas;

            subtotalLulusan = 0;
            subtotalSudah   = 0;
            subtotalBelum   = 0;

            html += `
                    <tr class="table-secondary">

                        <td colspan="6">
                            <strong>${row.fakultas}</strong>
                        </td>

                    </tr>
                `;
          }

          subtotalLulusan += Number(row.jumlah_lulusan);
          subtotalSudah   += Number(row.sudah_isi_tracer);
          subtotalBelum   += Number(row.belum_isi_tracer);

          html += `
                <tr>

                    <td></td>

                    <td>${row.program_studi}</td>

                    <td class="text-center">
                        ${Number(row.jumlah_lulusan).toLocaleString('id-ID')}
                    </td>

                    <td class="text-center">
                        ${Number(row.sudah_isi_tracer).toLocaleString('id-ID')}
                    </td>

                    <td class="text-center">
                        ${Number(row.belum_isi_tracer).toLocaleString('id-ID')}
                    </td>

                    <td class="text-center">
                        ${row.persentase}%
                    </td>

                </tr>
            `;
        });

        const persenSubtotal =
          subtotalLulusan > 0
            ? ((subtotalSudah * 100) / subtotalLulusan).toFixed(1)
            : 0;

        html += `
            <tr class="table-warning fw-bold">

                <td></td>

                <td>
                    Subtotal ${fakultasAktif}
                </td>

                <td class="text-center">
                    ${subtotalLulusan.toLocaleString('id-ID')}
                </td>

                <td class="text-center">
                    ${subtotalSudah.toLocaleString('id-ID')}
                </td>

                <td class="text-center">
                    ${subtotalBelum.toLocaleString('id-ID')}
                </td>

                <td class="text-center">
                    ${persenSubtotal}%
                </td>

            </tr>
        `;

        html += `
                    </tbody>
                </table>

            </div>

        </div>

    </div>
        `;

        hasilLaporan.innerHTML = html;
      }

      /**
       * LAPORAN UPBJJ
       */
      function renderTableUPBJJ(data, tahun) {

        if (!data.length) {

          hasilLaporan.innerHTML = `
                <div class="alert alert-warning">
                    Data tidak ditemukan.
                </div>
            `;
          return;
        }

        let totalLulusan = 0;
        let totalSudah   = 0;
        let totalBelum   = 0;

        let html = `
            <div class="card shadow-sm">
                <div class="card-body">

                    <h4 class="mb-3">
                        Ringkasan Tracer Berdasarkan UT Daerah Tahun ${tahun}
                    </h4>

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped">

                            <thead>
                                <tr class="header-biru">
                                    <th class="text-center">UT Daerah</th>
                                    <th class="text-center">Lulusan</th>
                                    <th class="text-center">Sudah Isi</th>
                                    <th class="text-center">Belum Isi</th>
                                    <th class="text-center">%</th>
                                </tr>
                            </thead>

                            <tbody>
        `;

        data.forEach(row => {

          totalLulusan += Number(row.jumlah_lulusan);
          totalSudah   += Number(row.sudah_isi_tracer);
          totalBelum   += Number(row.belum_isi_tracer);

          html += `
                <tr>

                    <td>${row.upbjj}</td>

                    <td class="text-center">
                        ${Number(row.jumlah_lulusan).toLocaleString('id-ID')}
                    </td>

                    <td class="text-center">
                        ${Number(row.sudah_isi_tracer).toLocaleString('id-ID')}
                    </td>

                    <td class="text-center">
                        ${Number(row.belum_isi_tracer).toLocaleString('id-ID')}
                    </td>

                    <td class="text-center">
                        ${row.persentase}%
                    </td>

                </tr>
            `;
        });

        const persenTotal =
          totalLulusan > 0
            ? ((totalSudah * 100) / totalLulusan).toFixed(1)
            : 0;

        html += `
            <tr class="table-warning fw-bold">

                <td>TOTAL</td>

                <td class="text-center">
                    ${totalLulusan.toLocaleString('id-ID')}
                </td>

                <td class="text-center">
                    ${totalSudah.toLocaleString('id-ID')}
                </td>

                <td class="text-center">
                    ${totalBelum.toLocaleString('id-ID')}
                </td>

                <td class="text-center">
                    ${persenTotal}%
                </td>

            </tr>

            </tbody>
            </table>
            </div>
            </div>
            </div>
        `;

        hasilLaporan.innerHTML = html;
      }

      /**
       * FAKULTAS PER UPBJJ
       */
      function renderTableFakultasUPBJJ(data, tahun) {

        hasilLaporan.innerHTML = `
            <div class="alert alert-info">
                Mode Fakultas per UT Daerah belum dibuat.
                Tinggal menyesuaikan query dan struktur data.
            </div>
        `;
      }

    });
  </script>
@endsection
