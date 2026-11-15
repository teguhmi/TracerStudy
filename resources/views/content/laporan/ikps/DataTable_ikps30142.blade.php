<div class="row mb-3">
  <div class="col-md-12">
    <h6 class="mb-0">
      Jumlah Responden :
      <span class="badge bg-primary">
                {{ optional($data->first())->jumlah_responden ?? 0 }} Orang
            </span>
    </h6>
  </div>
</div>

<div class="table-responsive">
  <table id="datatable-ikps30142" class="table table-bordered table-striped w-100">
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
    @forelse($data as $index => $row)
      <tr>
        <td class="text-center">
          {{ $index + 1 }}
        </td>

        <td>
          {{ $row->jenis_kemampuan }}
        </td>

        <td class="text-center">
          {{ $row->sangat_baik }}
        </td>

        <td class="text-center">
          {{ $row->baik }}
        </td>

        <td class="text-center">
          {{ $row->cukup }}
        </td>

        <td class="text-center">
          {{ $row->kurang }}
        </td>
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

@push('js')
  <script>
    $(function () {

      if ($.fn.DataTable.isDataTable('#datatable-ikps30142')) {
        $('#datatable-ikps30142').DataTable().destroy();
      }

      $('#datatable-ikps30142').DataTable({
        paging: false,
        searching: false,
        ordering: false,
        info: false,
        autoWidth: false,
        responsive: true,
        language: {
          emptyTable: 'Tidak ada data'
        }
      });

    });
  </script>
@endpush
