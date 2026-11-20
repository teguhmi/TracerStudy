@php
  $groupedData = $data->groupBy('kode_prodi_dikti');
@endphp

@foreach($groupedData as $kodeProdi => $rows)

  @php
    $prodi = $rows->first();
  @endphp

  <div class="card mb-4 border">

    <div class="card-header bg-primary text-white">
      <strong>
        {{ $prodi->kode_prodi_dikti }}
        -
        {{ $prodi->nama_prodi_dikti }}
      </strong>
    </div>

    <div class="card-body p-0">

      <table class="table table-bordered table-hover mb-0">

        <thead>
        <tr class="text-center">
          <th>Jenis Kemampuan</th>
          <th>Sangat Baik</th>
          <th>Baik</th>
          <th>Cukup</th>
          <th>Kurang</th>
        </tr>
        </thead>

        <tbody>

        @foreach($rows as $row)

          <tr>
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

@endforeach
