@extends('_include._template_menu')

@section('title', 'Laporan IKPS')

@section('content')

  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Laporan IKPS</h5>
    </div>

    <div class="card-body">

      <form method="GET" action="{{ route('laporan.ikps.data') }}">

        <div class="row">

          <div class="col-md-4">
            <label class="form-label">
              Tahun Lulus
            </label>

            <select
              id="tahun_lulus"
              name="tahun_lulus"
              class="form-select">

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
          </div>

          <div class="col-md-6">
            <label class="form-label">
              Indikator IKPS
            </label>

            <select
              id="jenis"
              name="jenis"
              class="form-select">

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
          </div>

          <div class="col-md-2 d-flex align-items-end">
            <button
              type="submit"
              class="btn btn-primary w-100">
              Tampilkan
            </button>
          </div>

        </div>

      </form>


    @if(request()->filled('jenis'))

      <div class="card mt-4">

        <div class="card-body">

          @if(request('jenis') == 'ikps30142')
            1
            {{--          @include('content.laporan.ikps.ikps30142')--}}
          @endif

          @if(request('jenis') == 'ikps32131')
            2
            {{--          @include('content.laporan.ikps.ikps32131')--}}
          @endif

          @if(request('jenis') == 'ikps35211')
            3
            {{--          @include('content.laporan.ikps.ikps35211')--}}
          @endif

          @if(request('jenis') == 'ikps35212')
            @include('content.laporan.ikps.DataTable_ikps35212')
          @endif

        </div>

      </div>

    @endif
  </div>
@endsection
