@php
  $rawUnit = request('unit_id', 0);
  $unitId = ($rawUnit === 'X3000') ? 0 : (int) $rawUnit;
  $isFakultas = ($unitId >= 1 && $unitId <= 6);
  $isUpbjj = ($unitId > 9);

  $dataKeseluruhan = $data->where('tipe_data', 'keseluruhan');
  $dataPerProdi = $data->where('tipe_data', 'prodi');
@endphp

{{-- DATA KESELURUHAN (UNIT_ID = 0 & PALING ATAS UNTUK UNIT_ID > 9) --}}
@if(($unitId === 0 || $isUpbjj) && $dataKeseluruhan->isNotEmpty())
  <div class="{{ $isUpbjj ? 'card mb-4 border' : '' }}">

    @if($isUpbjj)
      <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <strong>Keseluruhan</strong>
        <span class="badge bg-light text-dark">
          Jumlah Responden : {{ optional($dataKeseluruhan->first())->jumlah_responden ?? 0 }} Orang
        </span>
      </div>
      <div class="card-body p-0">
        @else
          <div class="row mb-3">
            <div class="col-md-12">
              <h6 class="mb-0">
                Jumlah Responden :
                <span class="badge bg-primary">
              {{ optional($dataKeseluruhan->first())->jumlah_responden ?? 0 }} Orang
            </span>
              </h6>
            </div>
          </div>
        @endif

        <div class="table-responsive">
          <table id="datatable-ikps30142" class="table table-bordered {{ $isUpbjj ? 'table-hover mb-0' : 'table-striped' }} w-100">
            <thead>
            <tr class="text-center align-middle">
              <th style="width: 60px;">No</th>
              <th>Jenis Kemampuan</th>
              <th style="width: 150px;">Sangat Baik</th>
              <th style="width: 150px;">Baik</th>
              <th style="width: 150px;">Cukup</th>
              <th style="width: 150px;">Kurang</th>
            </tr>
            </thead>

            <tbody>
            @forelse($dataKeseluruhan as $row)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $row->jenis_kemampuan }}</td>
                <td class="text-center">{{ $row->sangat_baik }}</td>
                <td class="text-center">{{ $row->baik }}</td>
                <td class="text-center">{{ $row->cukup }}</td>
                <td class="text-center">{{ $row->kurang }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center">
                  Tidak ada data.
                </td>
              </tr>
            @endforelse
            </tbody>
          </table>
        </div>

        @if($isUpbjj)
      </div>
    @endif

  </div>
@endif

{{-- DATA PER PRODI (UNIT_ID 1-6 & DI BAWAH KESELURUHAN UNTUK UNIT_ID > 9) --}}
@if(($isFakultas || $isUpbjj) && $dataPerProdi->isNotEmpty())
  @php
    $groupedData = $dataPerProdi->groupBy(function ($item) {
      return ($item->kode_prodi_dikti ?? '') . '|' . ($item->nama_prodi_dikti ?? '');
    });
  @endphp

  @foreach($groupedData as $rows)
    @php
      $prodi = $rows->first();
    @endphp

    <div class="card mb-4 border">

      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <strong>
          {{ $prodi->kode_prodi_dikti }} - {{ $prodi->nama_prodi_dikti }}@if(!empty($prodi->singkatan)) ({{ $prodi->singkatan }})@endif
        </strong>
        <span class="badge bg-light text-primary">
          Jumlah Responden : {{ $prodi->jumlah_responden ?? 0 }} Orang
        </span>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-bordered table-hover mb-0 w-100 datatable-ikps30142-prodi">
            <thead>
            <tr class="text-center align-middle">
              <th style="width: 60px;">No</th>
              <th>Jenis Kemampuan</th>
              <th style="width: 150px;">Sangat Baik</th>
              <th style="width: 150px;">Baik</th>
              <th style="width: 150px;">Cukup</th>
              <th style="width: 150px;">Kurang</th>
            </tr>
            </thead>

            <tbody>
            @foreach($rows as $row)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $row->jenis_kemampuan }}</td>
                <td class="text-center">{{ $row->sangat_baik }}</td>
                <td class="text-center">{{ $row->baik }}</td>
                <td class="text-center">{{ $row->cukup }}</td>
                <td class="text-center">{{ $row->kurang }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </div>
  @endforeach
@endif

@push('js')
  <script>
    $(function () {
      const dtConfig = {
        paging: false,
        searching: false,
        ordering: false,
        info: false,
        autoWidth: false,
        responsive: true,
        language: {
          emptyTable: 'Tidak ada data'
        }
      };

      if ($('#datatable-ikps30142').length) {
        if ($.fn.DataTable.isDataTable('#datatable-ikps30142')) {
          $('#datatable-ikps30142').DataTable().destroy();
        }
        $('#datatable-ikps30142').DataTable(dtConfig);
      }

      $('.datatable-ikps30142-prodi').each(function () {
        if ($.fn.DataTable.isDataTable(this)) {
          $(this).DataTable().destroy();
        }
        $(this).DataTable(dtConfig);
      });
    });
  </script>
@endpush
