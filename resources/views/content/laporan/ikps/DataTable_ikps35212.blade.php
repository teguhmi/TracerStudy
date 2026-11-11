<div class="table-responsive">
  <table class="table table-bordered">

    <thead class="table-primary">
    <tr>
      <th>No</th>
      <th>Tahun Lulusan</th>
      <th>Unit</th>
      <th>Jumlah Responden</th>
      <th>Jumlah Lulusan</th>
    </tr>
    </thead>

    <tbody>

    @forelse($data as $row)

      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $row->tahun_lulusan }}</td>
        <td>{{ $row->unit }}</td>
        <td>{{ number_format($row->jumlah_responden) }}</td>
        <td>{{ number_format($row->jumlah_lulusan) }}</td>
      </tr>

    @empty

      <tr>
        <td colspan="5" class="text-center">
          Tidak ada data
        </td>
      </tr>

    @endforelse

    </tbody>

  </table>
</div>
