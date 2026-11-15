@extends('_include._template_menu')

@section('title', 'Laporan IKPS')

@section('content')

  {{-- FILTER --}}
  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Laporan IKPS</h5>
    </div>

    <div class="card-body">

      <form id="form-ikps" method="GET" action="{{ route('laporan.ikps.data') }}">

        <div class="row">

          <div class="col-md-4">
            <label for="tahun_lulus" class="form-label">
              Tahun Lulus <span class="text-danger">*</span>
            </label>

            <select
              id="tahun_lulus"
              name="tahun_lulus"
              class="form-select"
              required>

              <option value="">
                Pilih Tahun
              </option>

              @foreach($tahun as $item)
                <option
                  value="{{ $item }}"
                  {{ request('tahun_lulus') == $item ? 'selected' : '' }}>
                  {{ $item }}
                </option>
              @endforeach

            </select>
            <div class="invalid-feedback">Silakan pilih tahun lulus terlebih dahulu.</div>
          </div>

          <div class="col-md-6">
            <label for="jenis" class="form-label">
              Indikator IKPS <span class="text-danger">*</span>
            </label>

            <select
              id="jenis"
              name="jenis"
              class="form-select"
              required>

              <option value="">
                Pilih IKPS
              </option>

              @foreach($ikps as $item)
                <option
                  value="{{ $item->kode }}"
                  {{ request('jenis') == $item->kode ? 'selected' : '' }}>
                  {{ $item->nama }}
                </option>
              @endforeach

            </select>
            <div class="invalid-feedback">Silakan pilih indikator IKPS terlebih dahulu.</div>
          </div>

          <div class="col-md-2 d-flex align-items-end">
            <button
              type="submit"
              id="btn-tampilkan"
              class="btn btn-primary w-100">
              Tampilkan
            </button>
          </div>

        </div>

      </form>

    </div>
  </div>

  @if(request()->filled('tahun_lulus') && request()->filled('jenis'))

    @php
      $selectedIkps = $ikps->firstWhere('kode', request('jenis'));
    @endphp

    {{-- HASIL --}}
    <div class="card mt-4">

      <div class="card-header">
        <h5 class="mb-0">
          {{ $selectedIkps->nama ?? 'Detail Laporan IKPS' }}
        </h5>
      </div>

      <div class="card-body">

        @switch(request('jenis'))

          @case('ikps30142')
            @include('content.laporan.ikps.DataTable_ikps30142')
            @break

          @case('ikps32131')
            {{-- @include('content.laporan.ikps.DataTable_ikps32131') --}}
            @break

          @case('ikps35211')
            @include('content.laporan.ikps.DataTable_ikps35211')
            @break

          @case('ikps35212')
            @include('content.laporan.ikps.DataTable_ikps35212')
            @break

        @endswitch

      </div>

    </div>

  @endif

@endsection

@section('script')
  <script>
    $(function () {

      // Cegah submit jika salah satu select kosong (mendukung HTML5 & Select2)
      $('#form-ikps').on('submit', function (e) {
        let isValid = true;

        $('#tahun_lulus, #jenis').each(function () {
          if (!$(this).val()) {
            $(this).addClass('is-invalid');
            isValid = false;
          } else {
            $(this).removeClass('is-invalid');
          }
        });

        if (!isValid) {
          e.preventDefault();
        }
      });

      // Hapus status error saat dropdown dipilih
      $('#tahun_lulus, #jenis').on('change', function () {
        if ($(this).val()) {
          $(this).removeClass('is-invalid');
        }
      });

      $('#datatable-wirausaha').DataTable({
        paging: false,
        searching: false,
        info: false,
        ordering: false
      });

      $('#datatable-freelancer').DataTable({
        paging: false,
        searching: false,
        info: false,
        ordering: false
      });

      $('#datatable-studi-lainnya').DataTable({
        paging: false,
        searching: false,
        info: false,
        ordering: false
      });

      $('#datatable-kepuasan-pengguna').DataTable({
        paging: false,
        searching: false,
        info: false,
        ordering: false
      });

    });
  </script>
@endsection
