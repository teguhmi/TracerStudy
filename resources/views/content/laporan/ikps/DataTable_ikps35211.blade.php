<!-- Tabel 1: Bekerja -->
<div class="table-responsive mb-4">
  <table class="table table-bordered text-center">
    <thead>
    <tr>
      <th>Tahun Pelaporan</th>
      <th>Total Jumlah Lulusan</th>
      <th>
        Jumlah Lulusan:
        <br>1. Bekerja
        <br>2. Gaji ≥ 1,2 UMP
        <br>3. Masa Tunggu ≤ 6 Bulan
      </th>
      <th>
        Jumlah Lulusan:
        <br>1. Bekerja
        <br>2. Gaji ≥ 1,2 UMP
        <br>3. Masa Tunggu > 6 Bulan ≤ 1 Tahun
      </th>
      <th>
        Jumlah Lulusan:
        <br>1. Bekerja
        <br>2. Gaji < 1,2 UMP
        <br>3. Masa Tunggu ≤ 12 Bulan
      </th>
    </tr>
    </thead>
    <tbody>
    @forelse ($data as $row)
      <tr>
        <td>{{ $row->tahun }}</td>
        <td>{{ $row->jumlah_lulusan ?? 0 }}</td>
        <td>{{ $row->dibawah_6 ?? 0 }}</td>
        <td>{{ $row->diatas_6 ?? 0 }}</td>
        <td>{{ $row->dibawah_ump_12 ?? 0 }}</td>
      </tr>
    @empty
      <tr>
        <td colspan="6">Data tidak tersedia</td>
      </tr>
    @endforelse
    </tbody>
  </table>
</div>

<!-- Tabel 2: DataTable Rincian Wirausaha -->
<div class="table-responsive mb-4">
  <table id="datatable-wirausaha" class="table table-bordered text-center">
    <thead>
    <tr>
      <th>Tahun Pelaporan</th>
      <th>
        Jumlah Lulusan:
        <br>1. Wirausaha
        <br>2. Pendapatan &gt;= 1,2 UMP
        <br>3. Masa Tunggu &lt;= 6 Bulan
      </th>
      <th>
        Jumlah Lulusan:
        <br>1. Wirausaha
        <br>2. Pendapatan &gt;= 1,2 UMP
        <br>3. Masa Tunggu &gt; 6 Bulan
      </th>
      <th>
        Jumlah Lulusan:
        <br>1. Wirausaha
        <br>2. Pendapatan &lt; 1,2 UMP
        <br>3. Masa Tunggu &lt;= 6 Bulan
      </th>
      <th>
        Jumlah Lulusan:
        <br>1. Wirausaha
        <br>2. Pendapatan &lt; 1,2 UMP
        <br>3. Masa Tunggu &gt; 6 Bulan
      </th>
    </tr>
    </thead>
    <tbody>
    @forelse ($data as $row)
      <tr>
        <td>{{ $row->tahun }}</td>
        <td>{{ $row->wirausaha_dibawah_6 ?? 0 }}</td>
        <td>{{ $row->wirausaha_diatas_6 ?? 0 }}</td>
        <td>{{ $row->wirausaha_dibawah_ump_6 ?? 0 }}</td>
        <td>{{ $row->wirausaha_dibawah_ump_diatas_6 ?? 0 }}</td>
      </tr>
    @empty
      <tr>
        <td colspan="5">Data tidak tersedia</td>
      </tr>
    @endforelse
    </tbody>
  </table>
</div>

<!-- Tabel 3: DataTable Rincian Freelancer -->
<div class="table-responsive">
  <table id="datatable-freelancer" class="table table-bordered text-center">
    <thead>
    <tr>
      <th>Tahun Pelaporan</th>
      <th>
        Jumlah Lulusan:
        <br>1. Freelancer
        <br>2. Pendapatan &gt;= 1,2 UMP
        <br>3. Masa Tunggu &lt;= 6 Bulan
      </th>
      <th>
        Jumlah Lulusan:
        <br>1. Freelancer
        <br>2. Pendapatan &gt;= 1,2 UMP
        <br>3. Masa Tunggu &gt; 6 Bulan
      </th>
      <th>
        Jumlah Lulusan:
        <br>1. Freelancer
        <br>2. Pendapatan &lt; 1,2 UMP
        <br>3. Masa Tunggu &lt;= 6 Bulan
      </th>
      <th>
        Jumlah Lulusan:
        <br>1. Freelancer
        <br>2. Pendapatan &lt; 1,2 UMP
        <br>3. Masa Tunggu &gt; 6 Bulan
      </th>
    </tr>
    </thead>
    <tbody>
    @forelse ($data as $row)
      <tr>
        <td>{{ $row->tahun }}</td>
        <td>{{ $row->freelancer_dibawah_6 ?? 0 }}</td>
        <td>{{ $row->freelancer_diatas_6 ?? 0 }}</td>
        <td>{{ $row->freelancer_dibawah_ump_6 ?? 0 }}</td>
        <td>{{ $row->freelancer_dibawah_ump_diatas_6 ?? 0 }}</td>
      </tr>
    @empty
      <tr>
        <td colspan="5">Data tidak tersedia</td>
      </tr>
    @endforelse
    </tbody>
  </table>
</div>

<!-- Tabel 4: DataTable Melanjutkan Studi & Tidak Masuk Kriteria -->
<div class="table-responsive mt-4">
  <table id="datatable-studi-lainnya" class="table table-bordered text-center">
    <thead>
    <tr>
      <th>Tahun Pelaporan</th>
      <th>Melanjutkan Studi</th>
      <th>Tidak Masuk Kriteria</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($data as $row)
      <tr>
        <td>{{ $row->tahun }}</td>
        <td>{{ $row->melanjutkan_studi ?? 0 }}</td>
        <td>{{ $row->tidak_masuk_kriteria ?? 0 }}</td>
      </tr>
    @empty
      <tr>
        <td colspan="3">Data tidak tersedia</td>
      </tr>
    @endforelse
    </tbody>
  </table>
</div>
