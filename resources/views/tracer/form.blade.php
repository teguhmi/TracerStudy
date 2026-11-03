@extends('_include._template_horizontal')

@section('head')
  <style>
    .sticky-bottom {
      position: sticky;
      bottom: 0;
      z-index: 100;
      backdrop-filter: blur(8px);
    }
    #btnNext, #btnSubmit { min-width: 140px; }
    @media (max-width: 768px) {
      .sticky-bottom .d-flex { flex-direction: column; gap: 10px; }
      .sticky-bottom .d-flex:last-child { width: 100%; }
      #btnPrev, #btnNext, #btnSubmit { width: 100%; }
    }
  </style>
@endsection

@section('content')
  @if($dpAlumni)
    @php
      $groupedSections = $sections->groupBy('section_id')->values();
    @endphp

    <form id="formTracer" method="POST" action="{{ route('tracer.simpan') }}">
      @csrf
      <input type="hidden" name="aksi" id="aksi" value="submit">

      <div class="container-xxl flex-grow-1 container-p-y">

        {{-- Progress Bar --}}
        <div class="card mb-4">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <span id="stepLabel">Langkah 1 dari {{ $groupedSections->count() }}</span>
              <span id="progressText">0%</span>
            </div>
            <div class="progress mt-2">
              <div id="progressBar" class="progress-bar" style="width:0"></div>
            </div>
          </div>
        </div>

        {{-- Biodata Alumni --}}
        <div class="card shadow-lg border-0 mb-4">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <div class="avatar avatar-xl">
                  <span class="avatar-initial rounded-circle bg-label-primary">
                    {{ strtoupper(substr($dpAlumni->nama_mahasiswa, 0, 1)) }}
                  </span>
                </div>
              </div>
              <div class="col">
                <h4 class="mb-1 fw-bold">{{ $dpAlumni->nama_mahasiswa }}</h4>
                <div class="text-muted">NIM : {{ $dpAlumni->nim }}</div>
                <div class="small text-muted">{{ $dpAlumni->nama_program_studi }}</div>
              </div>
              <div class="col-md-auto text-md-end">
                <span class="badge bg-success">Alumni UT</span>
                <div class="small text-muted mt-2">
                  Lulus {{ \Carbon\Carbon::parse($dpAlumni->tanggal_sk)->translatedFormat('d F Y') }}
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Section Wizard --}}
        @foreach($groupedSections as $sectionIndex => $sectionQuestions)
          @php $firstQuestion = $sectionQuestions->first(); @endphp

          <div
            class="wizard-section"
            id="section-{{ $sectionIndex }}"
            data-kode="{{ $firstQuestion->section->kode }}"
            data-rule="{{ json_encode($firstQuestion->section->tampil_jika ?? []) }}"
          >
            <div class="card border-primary mb-4">
              <div class="card-header bg-label-primary">
                <h5 class="mb-0 fw-bold">{{ $firstQuestion->section->nama ?? 'Section' }}</h5>
              </div>
            </div>

            @foreach($sectionQuestions as $q)
              @php $value = old('jawaban.'.$q->kode, $jawabanLama[$q->kode] ?? ''); @endphp

              @if(in_array($q->kode, ['F17A', 'F17B', 'F2']))
                <div class="card border-info mb-4">
                  <div class="card-header bg-label-info">
                    <h5 class="mb-0 fw-bold">[{{ $q->kode }}] {{ $q->pertanyaan }}</h5>
                  </div>
                </div>
                @continue
              @endif

              <div
                class="card mb-3 shadow-sm pertanyaan"
                id="card-{{ $q->kode }}"
                data-kode="{{ $q->kode }}"
                data-tampil-jika="{{ json_encode($q->tampil_jika ?? []) }}"
                @if(in_array($q->kode, ['F5A1', 'F5A2'])) style="display:none" @endif
              >
                <div class="card-body">
                  <div class="mb-3">
                    <span class="badge bg-label-primary">{{ $q->kode }}</span>
                    <h6 class="mt-2 mb-0">
                      {{ $q->pertanyaan }}
                      @if($q->wajib) <span class="text-danger">*</span> @endif
                    </h6>
                  </div>

                  {{-- TEXT --}}
                  @if($q->jenis == 'text')
                    <input
                      type="text"
                      class="form-control"
                      name="jawaban[{{ $q->kode }}]"
                      value="{{ old('jawaban.'.$q->kode, $jawabanLama[$q->kode] ?? '') }}"
                      placeholder="{{ $q->placeholder }}"
                      maxlength="255"
                      {{ $q->wajib ? 'required' : '' }}
                      data-required="{{ $q->wajib ? 1 : 0 }}"
                    >

                    {{-- TEXTAREA --}}
                  @elseif($q->jenis == 'textarea')
                    <textarea
                      class="form-control"
                      rows="3"
                      name="jawaban[{{ $q->kode }}]"
                      {{ $q->wajib ? 'required' : '' }}
                      data-required="{{ $q->wajib ? 1 : 0 }}"
                    >{{ old('jawaban.'.$q->kode, $jawabanLama[$q->kode] ?? '') }}</textarea>

                    {{-- NUMBER --}}
                  @elseif($q->jenis == 'number')
                    @if($q->kode == 'F505')
                      <div class="row g-3">
                        <div class="col-md-4">
                          <label class="form-label">Rentang Pendapatan</label>
                          <select id="range_F505" name="jawaban[F505_range]" class="form-select">
                            <option value="">Pilih Rentang</option>
                            <option data-min="0" data-max="999999">< Rp 1 Juta</option>
                            <option data-min="1000000" data-max="2999999">Rp 1 - <3 Juta</option>
                            <option data-min="3000000" data-max="4999999">Rp 3 - <5 Juta</option>
                            <option data-min="5000000" data-max="9999999">Rp 5 - <10 Juta</option>
                            <option data-min="10000000" data-max="19999999">Rp 10 - <20 Juta</option>
                            <option data-min="20000000" data-max="49999999">Rp 20 - >50 Juta</option>
                            <option data-min="50000000" data-max="999999999">> Rp 50 Juta</option>
                          </select>
                        </div>
                        <div class="col-md-8">
                          <label class="form-label">Pendapatan Aktual (Rp)</label>
                          <input
                            type="text"
                            class="form-control rupiah-display"
                            data-target="{{ $q->kode }}"
                            value="{{ old('jawaban.F505', $jawabanLama['F505'] ?? '') }}"
                            placeholder="Contoh: 7.500.000"
                            maxlength="10"
                          >
                          <input
                            type="hidden"
                            id="value_{{ $q->kode }}"
                            name="jawaban[{{ $q->kode }}]"
                            value="{{ old('jawaban.F505', $jawabanLama['F505'] ?? '') }}"
                            maxlength="10"
                          >
                          <small id="preview_F505" class="text-muted mt-1 d-block"></small>
                          <small id="warning_F505" class="text-danger mt-1 d-none">
                            Rentang pendapatan tidak sesuai dengan pendapatan aktual.
                          </small>
                        </div>
                      </div>
                    @else
                      <input
                        type="number"
                        class="form-control"
                        name="jawaban[{{ $q->kode }}]"
                        value="{{ old('jawaban.'.$q->kode, $jawabanLama[$q->kode] ?? '') }}"
                        {{ $q->wajib ? 'required' : '' }}
                        data-required="{{ $q->wajib ? 1 : 0 }}"
                      >
                    @endif

                    {{-- DATE --}}
                  @elseif($q->jenis == 'date')
                    <input
                      type="date"
                      class="form-control"
                      name="jawaban[{{ $q->kode }}]"
                      value="{{ old('jawaban.'.$q->kode, $jawabanLama[$q->kode] ?? '') }}"
                      {{ $q->wajib ? 'required' : '' }}
                      data-required="{{ $q->wajib ? 1 : 0 }}"
                    >

                    {{-- RADIO --}}
                  @elseif($q->jenis == 'radio')
                    <div class="row">
                      @foreach($q->opsi as $opsi)
                        <div class="col-lg-6 col-md-6 col-12 mb-2">
                          <label class="option-card">
                            <input
                              type="radio"
                              class="form-check-input me-2 trigger-conditional"
                              name="jawaban[{{ $q->kode }}]"
                              value="{{ $opsi->nilai }}"
                              @checked(old('jawaban.'.$q->kode, $jawabanLama[$q->kode] ?? '') == $opsi->nilai)
                              {{ $q->wajib ? 'required' : '' }}
                              data-required="{{ $q->wajib ? 1 : 0 }}"
                            >
                            <span><strong>{{ $opsi->nilai }}</strong> - {{ $opsi->label }}</span>
                          </label>
                        </div>
                      @endforeach
                    </div>

                    {{-- CHECKBOX --}}
                  @elseif($q->jenis == 'checkbox')
                    <div class="row">
                      @foreach($q->opsi as $opsi)
                        <div
                          class="col-lg-6 col-md-6 col-12 mb-2 opsi-wrapper"
                          data-opsi-tampil-jika='@json($opsi->tampil_jika ?? [])'                        >
                          <label class="option-card">
                            <input
                              type="checkbox"
                              class="form-check-input me-2"
                              name="jawaban[{{ $q->kode }}][]"
                              value="{{ $opsi->nilai }}"
                              data-required="{{ $q->wajib ? 1 : 0 }}"
                              @checked(
                                  in_array(
                                      $opsi->nilai,
                                      old(
                                          'jawaban.'.$q->kode,
                                          is_array($jawabanLama[$q->kode] ?? null)
                                              ? $jawabanLama[$q->kode]
                                              : (isset($jawabanLama[$q->kode]) ? json_decode($jawabanLama[$q->kode], true) ?? [] : [])
                                      )
                                  )
                              )
                            >
                            <span>
                    @if(str_starts_with($opsi->nilai, 'F'))
                                <strong>[{{ $opsi->nilai }}]</strong>
                              @endif

                              {{ $opsi->label }}
                </span>
                          </label>
                        </div>
                      @endforeach
                    </div>

                    {{-- SELECT --}}
                  @elseif($q->jenis == 'select')
                    @php $name = "jawaban[$q->kode]"; @endphp
                    @switch($q->kode)
                      @case('BIO05')
                        <select
                          class="form-select"
                          id="bio05"
                          name="{{ $name }}"
                          data-selected="{{ old('jawaban.BIO05', $valueBio05 ?? '') }}"
                          {{ $q->wajib ? 'required' : '' }}
                          data-required="{{ $q->wajib ? 1 : 0 }}"
                        >
                          <option value="">Pilih Negara</option>
                        </select>
                        @break

                      @case('BIO06')
                        <select
                          id="bio06"
                          name="{{ $name }}"
                          class="form-select"
                          data-selected="{{ old('jawaban.BIO06', $valueBio06 ?? '') }}"
                          data-required="{{ $q->wajib ? 1 : 0 }}"
                        >
                          <option value="">Pilih Provinsi</option>
                        </select>
                        @break

                      @case('BIO07')
                        <select
                          id="bio07"
                          name="{{ $name }}"
                          class="form-select"
                          data-selected="{{ old('jawaban.BIO07', $valueBio07 ?? '') }}"
                          data-required="{{ $q->wajib ? 1 : 0 }}"
                        >
                          <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                        @break

                      @case('F5A0')
                        <select
                          class="form-select"
                          id="negara_id"
                          name="{{ $name }}"
                          {{ $q->wajib ? 'required' : '' }}
                          data-required="{{ $q->wajib ? 1 : 0 }}"
                        >
                          <option value="">Pilih Negara</option>
                          @foreach($negaras as $negara)
                            <option
                              value="{{ $negara->kode }}"
                              {{ (string) old('jawaban.F5A0', $jawabanLama['F5A0'] ?? '') === (string) $negara->kode ? 'selected' : '' }}
                            >
                              {{ $negara->nama }}
                            </option>
                          @endforeach
                        </select>
                        @break

                      @case('F5A1')
                        <select
                          id="f5a1"
                          name="{{ $name }}"
                          class="form-select"
                          data-required="{{ $q->wajib ? 1 : 0 }}"
                        >
                          <option value="">Pilih Provinsi</option>
                          @foreach($provinsis as $provinsi)
                            @if($provinsi->kode != '999999')
                              <option
                                value="{{ $provinsi->kode }}"
                                @selected(old('jawaban.F5A1', $jawabanLama['F5A1'] ?? '') == $provinsi->kode)
                              >
                                {{ $provinsi->nama }}
                              </option>
                            @endif
                          @endforeach
                        </select>
                        @break

                      @case('F5A2')
                        <select
                          id="f5a2"
                          name="{{ $name }}"
                          class="form-select"
                          data-selected="{{ old('jawaban.F5A2', $jawabanLama['F5A2'] ?? '') }}"
                          data-required="{{ $q->wajib ? 1 : 0 }}"
                        >
                          <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                        @break

                      @default
                        <select class="form-select" name="{{ $name }}">
                          <option value="">Pilih</option>
                          @foreach($q->opsi as $opsi)
                            <option
                              value="{{ $opsi->nilai }}"
                              @selected(old('jawaban.'.$q->kode, $jawabanLama[$q->kode] ?? '') == $opsi->nilai)
                            >
                              {{ $opsi->label }}
                            </option>
                          @endforeach
                        </select>
                    @endswitch
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        @endforeach

        {{-- NAVIGATION --}}
        <div class="sticky-bottom bg-white border-top shadow-sm p-3">
          <div class="d-flex align-items-center justify-content-between">
            <div class="small text-muted"><span id="stepInfo"></span></div>
            <div class="d-flex gap-2">
              <button type="button" id="btnPrev" class="btn btn-light border px-4">
                <i class="bi bi-arrow-left"></i> Sebelumnya
              </button>
              <button type="button" id="btnNext" class="btn btn-primary px-4">
                Selanjutnya <i class="bi bi-arrow-right"></i>
              </button>
              <button
                type="submit"
                id="btnSubmit"
                class="btn btn-success px-4 d-none"
              >
                <i class="bi bi-check-circle"></i> Kirim Jawaban
              </button>
            </div>
          </div>
        </div>

      </div>
    </form>
  @endif
@endsection

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  {{-- Inisialisasi dynamic URL Blade untuk script eksternal --}}

@endpush
