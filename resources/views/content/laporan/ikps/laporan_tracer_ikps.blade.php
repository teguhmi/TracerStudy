@extends('_include._template_menu')

@section('title', 'Laporan IKPS')

@section('content')

  @php
    $selectedJenis = strtolower(trim((string) request('jenis')));
    $isIkps30142 = ($selectedJenis === 'ikps30142');
  @endphp

  <div class="w-100">

    {{-- FILTER --}}
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Laporan IKPS</h5>
      </div>

      <div class="card-body">

        <form id="form-ikps" method="GET" action="{{ route('laporan.ikps.data') }}">

          <div class="row">

            <div class="col-md-3">
              <label for="tahun_lulus" class="form-label">
                Tahun Lulus <span class="text-danger">*</span>
              </label>

              <select
                id="tahun_lulus"
                name="tahun_lulus"
                class="form-select"
                required>
                <option value="">Pilih Tahun</option>

                @foreach($tahun as $item)
                  <option
                    value="{{ $item }}"
                    {{ request('tahun_lulus') == $item ? 'selected' : '' }}>
                    {{ $item }}
                  </option>
                @endforeach
              </select>

              <div class="invalid-feedback">
                Silakan pilih tahun lulus terlebih dahulu.
              </div>
            </div>

            <div class="col-md-4">
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
                    {{ $selectedJenis === strtolower(trim((string) $item->kode)) ? 'selected' : '' }}>
                    {{ $item->nama }}
                  </option>
                @endforeach

              </select>

              <div class="invalid-feedback">
                Silakan pilih indikator IKPS terlebih dahulu.
              </div>
            </div>

            <div
              id="wrapper-unit"
              class="col-md-3 {{ $isIkps30142 ? '' : 'd-none' }}"
              style="{{ $isIkps30142 ? '' : 'display: none;' }}">
              <label for="unit_id" class="form-label">
                Unit <span class="text-danger">*</span>
              </label>

              <select
                id="unit_id"
                name="unit_id"
                class="form-select"
                {{ $isIkps30142 ? 'required' : '' }}>

                <option value="">
                  Pilih Unit
                </option>

                @foreach($units as $unit)
                  <option
                    value="{{ $unit->kode_upbjj }}"
                    {{ (string) request('unit_id') === (string) $unit->kode_upbjj ? 'selected' : '' }}>
                    {{ $unit->nama_unit }}
                  </option>
                @endforeach

              </select>

              <div class="invalid-feedback">
                Silakan pilih unit terlebih dahulu.
              </div>
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
        $selectedIkps = $ikps->first(function ($item) use ($selectedJenis) {
          return strtolower(trim((string) $item->kode)) === $selectedJenis;
        });
      @endphp

      <div class="card mt-4">

        <div class="card-header">
          <h5 class="mb-0">
            {{ ($selectedIkps->nama ?? 'Detail Laporan IKPS') . (!empty($selectedIkps->keterangan) ? ' - ' . $selectedIkps->keterangan : '') }}
          </h5>
        </div>

        <div class="card-body">

          @if($data->isNotEmpty())

            @switch($selectedJenis)

              @case('ikps30142')
                @include('content.laporan.ikps.DataTable_ikps30142')
                @break

              @case('ikps35211')
                @include('content.laporan.ikps.DataTable_ikps35211')
                @break

              @case('ikps35212')
                @include('content.laporan.ikps.DataTable_ikps35212')
                @break

            @endswitch

          @else

            <div class="alert alert-warning mb-0">
              <i class="mdi mdi-information-outline"></i>
              Data tidak ditemukan untuk filter yang dipilih.
            </div>

          @endif

        </div>

      </div>

    @endif

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const jenisEl = document.getElementById('jenis');
      const wrapperUnit = document.getElementById('wrapper-unit');
      const unitEl = document.getElementById('unit_id');
      const tahunEl = document.getElementById('tahun_lulus');
      const formEl = document.getElementById('form-ikps');

      function isIkps30142Selected() {
        return jenisEl && (jenisEl.value || '').trim().toLowerCase() === 'ikps30142';
      }

      function toggleUnitField() {
        if (!jenisEl || !wrapperUnit || !unitEl) return;

        if (isIkps30142Selected()) {
          wrapperUnit.classList.remove('d-none');
          wrapperUnit.style.display = '';
          unitEl.required = true;
        } else {
          wrapperUnit.classList.add('d-none');
          wrapperUnit.style.display = 'none';
          unitEl.required = false;
          unitEl.classList.remove('is-invalid');
          unitEl.value = '';

          if (window.jQuery && window.jQuery(unitEl).data('select2')) {
            window.jQuery(unitEl).val('').trigger('change.select2');
          }
        }
      }

      // Sinkronkan saat halaman selesai dimuat & saat dropdown IKPS berubah
      toggleUnitField();

      if (jenisEl) {
        jenisEl.addEventListener('change', toggleUnitField);
      }

      if (window.jQuery) {
        window.jQuery('#jenis').on('change select2:select', toggleUnitField);
      }

      // Validasi submit
      if (formEl) {
        formEl.addEventListener('submit', function (e) {
          let isValid = true;
          const fields = isIkps30142Selected()
            ? [tahunEl, jenisEl, unitEl]
            : [tahunEl, jenisEl];

          fields.forEach(function (el) {
            if (!el) return;
            if (!el.value) {
              el.classList.add('is-invalid');
              isValid = false;
            } else {
              el.classList.remove('is-invalid');
            }
          });

          if (!isValid) {
            e.preventDefault();
          }
        });
      }

      // Hapus status error saat dropdown dipilih
      [tahunEl, jenisEl, unitEl].forEach(function (el) {
        if (!el) return;
        el.addEventListener('change', function () {
          if (el.value) {
            el.classList.remove('is-invalid');
          }
        });
      });

      // Inisialisasi DataTable lainnya jika jQuery tersedia
      if (window.jQuery && window.jQuery.fn.DataTable) {
        const defaultDtConfig = {
          paging: false,
          searching: false,
          info: false,
          ordering: false
        };

        [
          '#datatable-wirausaha',
          '#datatable-freelancer',
          '#datatable-studi-lainnya',
          '#datatable-kepuasan-pengguna'
        ].forEach(function (selector) {
          if (window.jQuery(selector).length) {
            window.jQuery(selector).DataTable(defaultDtConfig);
          }
        });
      }
    });
  </script>

@endsection

@section('script')
  @stack('js')
@endsection
