@extends('_include._template')
@section('head')
  <style>
    .sticky-bottom{
      position: sticky;
      bottom: 0;
      z-index: 100;
      backdrop-filter: blur(8px);
    }

    #btnNext,
    #btnSubmit{
      min-width: 140px;
    }

    @media(max-width:768px){

      .sticky-bottom .d-flex{
        flex-direction: column;
        gap: 10px;
      }

      .sticky-bottom .d-flex:last-child{
        width:100%;
      }

      #btnPrev,
      #btnNext,
      #btnSubmit{
        width:100%;
      }
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

      {{--      <input type="hidden" name="nim" id="nim" value="@if($nimAlumni){{ $nimAlumni }}@endif">--}}

      <div class="container-xxl flex-grow-1 container-p-y">

        {{-- Progress --}}
        <div class="card mb-4">
          <div class="card-body">

            <div class="d-flex justify-content-between">
                    <span id="stepLabel">
                        Langkah 1 dari {{ $groupedSections->count() }}
                    </span>

              <span id="progressText">
                        0%
                    </span>
            </div>

            <div class="progress mt-2">
              <div
                id="progressBar"
                class="progress-bar"
                style="width:0"
              ></div>
            </div>

          </div>
        </div>

        {{-- Biodata --}}
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

                <h4 class="mb-1 fw-bold">
                  {{ $dpAlumni->nama_mahasiswa }}
                </h4>

                <div class="text-muted">
                  NIM : {{ $dpAlumni->nim }}
                </div>

                <div class="small text-muted">
                  {{ $dpAlumni->nama_program_studi }}
                </div>

              </div>

              <div class="col-md-auto text-md-end">

                <span class="badge bg-success">
                    Alumni UT
                </span>

                <div class="small text-muted mt-2">
                  Lulus
                  {{ \Carbon\Carbon::parse($dpAlumni->tanggal_sk)->translatedFormat('d F Y') }}
                </div>

              </div>

            </div>

          </div>
        </div>
        @foreach($groupedSections as $sectionIndex => $sectionQuestions)

          @php
            $firstQuestion = $sectionQuestions->first();
          @endphp

          <div
            class="wizard-section"
            id="section-{{ $sectionIndex }}"
            data-kode="{{ $firstQuestion->section->kode }}"
            {{--            data-rule='@json($firstQuestion->section->tampil_jika ?? [])'--}}
            data-rule="{{ json_encode($firstQuestion->section->tampil_jika ?? []) }}"
          >

            {{-- Header Section --}}
            <div class="card border-primary mb-4">
              <div class="card-header bg-label-primary">

                <h5 class="mb-0 fw-bold">
                  {{ $firstQuestion->section->nama ?? 'Section' }}
                </h5>

              </div>
            </div>

            {{-- Pertanyaan disini --}}
            @foreach($sectionQuestions as $q)

              {{-- HEADER GROUP --}}
              @if(in_array($q->kode,['F17A','F17B','F2']))

                <div class="card border-info mb-4">
                  <div class="card-header bg-label-info">

                    <h5 class="mb-0 fw-bold">
                      [{{ $q->kode }}]
                      {{ $q->pertanyaan }}
                    </h5>

                  </div>
                </div>

                @continue

              @endif

              {{--          <div class="card mb-3 shadow-sm">--}}
              <div
                class="card mb-3 shadow-sm pertanyaan"
                id="card-{{ $q->kode }}"
                data-kode="{{ $q->kode }}"
                {{--                data-tampil-jika='@json($q->tampil_jika ?? [])'--}}
                data-tampil-jika="{{ json_encode($q->tampil_jika ?? []) }}"

                @if(in_array($q->kode,['F5A1','F5A2']))
                  style="display:none"
                @endif
              >
                <div class="card-body">

                  <div class="mb-3">

                            <span class="badge bg-label-primary">
                                {{ $q->kode }}
                            </span>

                    <h6 class="mt-2 mb-0">
                      {{ $q->pertanyaan }}

                      @if($q->wajib)
                        <span class="text-danger">*</span>
                      @endif
                    </h6>

                  </div>

                  {{-- TEXT --}}
                  @if($q->jenis == 'text')

                    <input
                      type="text"
                      class="form-control"
                      name="jawaban[{{ $q->kode }}]"
                      placeholder="{{ $q->placeholder }}"
                      maxlength="255"
                    >

                    {{-- TEXTAREA --}}
                  @elseif($q->jenis == 'textarea')

                    <textarea
                      class="form-control"
                      rows="3"
                      name="jawaban[{{ $q->kode }}]"
                      placeholder="{{ $q->placeholder }}"
                      maxlength="255"
                    ></textarea>

                    {{-- NUMBER --}}
                  @elseif($q->jenis == 'number')

                    @if($q->kode == 'F505')

                      <div class="row g-3">

                        <div class="col-md-4">
                          <label class="form-label">
                            Rentang Pendapatan
                          </label>

                          <select
                            id="range_F505"
                            name="jawaban[F505_range]"
                            class="form-select"
                          >
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
                          <label class="form-label">
                            Pendapatan Aktual (Rp)
                          </label>

                          <input
                            type="text"
                            class="form-control rupiah-display"
                            data-target="{{ $q->kode }}"
                            placeholder="Contoh: 7.500.000" maxlength="10">

                          <input
                            type="hidden"
                            id="value_{{ $q->kode }}"
                            name="jawaban[{{ $q->kode }}]"
                            maxlength="10">
                          <small
                            id="preview_F505"
                            class="text-muted mt-1 d-block"
                          ></small>
                          <small
                            id="warning_F505"
                            class="text-danger mt-1 d-none">
                            Rentang pendapatan tidak sesuai dengan pendapatan aktual.
                          </small>
                        </div>

                      </div>

                    @else

                      <input
                        type="number"
                        class="form-control"
                        name="jawaban[{{ $q->kode }}]"
                      >

                    @endif

                    {{--                  @elseif($q->jenis == 'number')--}}

                    {{--                    <input--}}
                    {{--                      type="number"--}}
                    {{--                      class="form-control"--}}
                    {{--                      name="jawaban[{{ $q->kode }}]"--}}
                    {{--                    >--}}

                    {{-- DATE --}}
                  @elseif($q->jenis == 'date')

                    <input
                      type="date"
                      class="form-control"
                      name="jawaban[{{ $q->kode }}]"
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
                              {{ $q->wajib ? 'required' : '' }}
                              data-required="{{ $q->wajib ? 1 : 0 }}"
                            >


                            <span>
                                                <strong>
                                                    {{ $opsi->nilai }}
                                                </strong>
                                                -
                                                {{ $opsi->label }}
                                            </span>

                          </label>

                        </div>

                      @endforeach

                    </div>

                    {{-- CHECKBOX --}}
                  @elseif($q->jenis == 'checkbox')

                    <div class="row">

                      @foreach($q->opsi as $opsi)

                        <div class="col-lg-6 col-md-6 col-12 mb-2">

                          <label class="option-card">

                            <input type="checkbox" class="form-check-input me-2" name="jawaban[{{ $q->kode }}][]"
                                   value="{{ $opsi->nilai }}">

                            <span>
                              @if(str_starts_with($opsi->nilai,'F'))
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

                    @php
                      $name = "jawaban[$q->kode]";
                    @endphp

                    @switch($q->kode)

                      @case('F5A0')
                        <select class="form-select" id="negara_id" name="{{ $name }}">
                          <option value="">Pilih Negara</option>
                          @foreach($negaras as $negara)
                            <option value="{{ $negara->kode }}">
                              {{ $negara->nama }}
                            </option>
                          @endforeach
                        </select>
                        @break

                      @case('F5A1')
                        <select id="f5a1" name="{{ $name }}" class="form-select">
                          <option value="">Pilih Provinsi</option>
                          @if($provinsis->kode != '999999')
                            <option value="{{ $provinsi->kode }}">
                              {{ $provinsi->nama }}
                            </option>
                          @endif


                      @case('F5A2')
                        <select class="form-select" id="f5a2" name="{{ $name }}">

                        </select>
                        @break

                      @default
                        <select class="form-select" name="{{ $name }}">
                          <option value="">Pilih</option>

                          @foreach($q->opsi as $opsi)
                            <option value="{{ $opsi->nilai }}">
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

            <!-- Info Section -->
            <div class="small text-muted">
            <span id="stepInfo">
{{--                Bagian <span id="currentStep">1</span> dari--}}
{{--                <span id="totalStep">{{ count($sections) }}</span>--}}
            </span>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2">

              <button
                type="button"
                id="btnPrev"
                class="btn btn-light border px-4"
                onclick="prevSection()">
                <i class="bi bi-arrow-left"></i>
                Sebelumnya
              </button>

              <button
                type="button"
                id="btnNext"
                class="btn btn-primary px-4"
                onclick="nextSection()">
                Selanjutnya
                <i class="bi bi-arrow-right"></i>
              </button>

              <button
                type="submit"
                id="btnSubmit"
                class="btn btn-success px-4 d-none">
                <i class="bi bi-check-circle"></i>
                Kirim Jawaban
              </button>

            </div>

          </div>

        </div>

      </div>
    </form>
  @endif
@endsection

{{--@push('css')--}}
{{--  <style>--}}

{{--    .option-card {--}}
{{--      display: flex;--}}
{{--      align-items: center;--}}
{{--      gap: 10px;--}}
{{--      border: 1px solid #ddd;--}}
{{--      border-radius: 10px;--}}
{{--      padding: 12px;--}}
{{--      cursor: pointer;--}}
{{--      width: 100%;--}}
{{--      transition: .2s;--}}
{{--    }--}}

{{--    .option-card:hover {--}}
{{--      background: #f8f9fa;--}}
{{--      border-color: #696cff;--}}
{{--    }--}}

{{--  </style>--}}
{{--@endpush--}}

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {

      renderWizard();

      toggleIndonesiaFields();

      const negara = document.getElementById('negara_id');

      if (negara) {
        negara.addEventListener(
          'change',
          toggleIndonesiaFields
        );
      }

    });
  </script>
  <script>
    let currentStep = 0;
    /*
    |--------------------------------------------------------------------------
    | Utility
    |--------------------------------------------------------------------------
    */
    const allSections = () =>
      [...document.querySelectorAll('.wizard-section')];

    /*
    |--------------------------------------------------------------------------
    | Rule Section
    |--------------------------------------------------------------------------
    */
    function isSectionVisible(section) {
      const rule = section.dataset.rule;

      // section tanpa rule selalu tampil
      if (!rule || rule === '{}' || rule === '[]') {
        return true;
      }

      try {

        const rules = JSON.parse(rule);
        return Object.entries(rules).every(
          ([field, allowed]) => {
            const checked =
              document.querySelector(
                `[name="jawaban[${field}]"]:checked`
              );

            if (!checked) {
              return false;
            }

            return allowed
              .map(String)
              .includes(
                String(checked.value)
              );
          }
        );

      } catch (e) {

        console.error(e);

        return true;
      }
    }

    /*
    |--------------------------------------------------------------------------
    | Rule Pertanyaan
    |--------------------------------------------------------------------------
    */
    function evaluateRules() {

      document
        .querySelectorAll('.pertanyaan')
        .forEach(card => {

          const rule = card.dataset.tampilJika;

          if (
            !rule ||
            rule === '{}' ||
            rule === '[]'
          ) {

            toggleQuestion(card, true);
            return;
          }

          try {

            const rules = JSON.parse(rule);

            const visible = Object.entries(rules)
              .every(([field, allowed]) => {

                let value = null;

                // RADIO
                const radio = document.querySelector(
                  `[name="jawaban[${field}]"]:checked`
                );

                if (radio) {
                  value = radio.value;
                }

                // CHECKBOX
                const checkboxes =
                  document.querySelectorAll(
                    `[name="jawaban[${field}][]"]:checked`
                  );

                if (
                  !value &&
                  checkboxes.length > 0
                ) {

                  const values =
                    [...checkboxes]
                      .map(x => String(x.value));

                  return allowed.some(item =>
                    values.includes(
                      String(item)
                    )
                  );
                }

                // SELECT / TEXTAREA / TEXT
                if (!value) {

                  const fieldEl =
                    document.querySelector(
                      `[name="jawaban[${field}]"]`
                    );

                  if (fieldEl) {
                    value = fieldEl.value;
                  }
                }

                // wildcard *
                if (
                  allowed.length === 1 &&
                  allowed[0] === '*'
                ) {

                  return (
                    value !== null &&
                    value !== ''
                  );
                }

                return allowed
                  .map(String)
                  .includes(
                    String(value)
                  );

              });

            toggleQuestion(
              card,
              visible
            );

          } catch (e) {

            console.error(
              'Rule Error:',
              card.dataset.kode,
              e
            );

          }

        });

    }

    /*
    |--------------------------------------------------------------------------
    | Section Tampil
    |--------------------------------------------------------------------------
    */
    function getVisibleSections() {

      return allSections()
        .filter(section => {

          const visibleQuestions =
            [...section.querySelectorAll('.pertanyaan')]
              .filter(card =>
                card.style.display !== 'none'
              );

          return visibleQuestions.length > 0;

        });

    }

    /*
    |--------------------------------------------------------------------------
    | Render Wizard
    |--------------------------------------------------------------------------
    */
    function renderWizard() {
      evaluateRules();

      const visibleSections =
        getVisibleSections();

      if (!visibleSections.length) {
        return;
      }

      if (currentStep >= visibleSections.length) {
        currentStep =
          visibleSections.length - 1;
      }

      allSections().forEach(
        section =>
          section.style.display = 'none'
      );

      visibleSections[currentStep]
        .style.display = 'block';

      const total =
        visibleSections.length;

      document.getElementById('btnPrev')
        .style.display =
        currentStep === 0
          ? 'none'
          : '';

      document.getElementById('btnNext')
        .classList.toggle(
        'd-none',
        currentStep >= total - 1
      );

      document.getElementById('btnSubmit')
        .classList.toggle(
        'd-none',
        currentStep < total - 1
      );

      const percent =
        Math.round(
          ((currentStep + 1) / total) * 100
        );

      progressBar.style.width =
        percent + '%';

      progressText.innerText =
        percent + '%';

      stepLabel.innerText =
        `Langkah ${currentStep + 1} dari ${total}`;
    }

    function toggleQuestion(card, visible) {

      const inputs =
        card.querySelectorAll(
          'input, select, textarea'
        );

      card.style.display =
        visible ? '' : 'none';

      inputs.forEach(el => {

        if (visible) {

          if (
            el.dataset.required === '1'
          ) {
            el.required = true;
          }

        } else {

          el.required = false;
        }

      });
    }

    document
      .getElementById('formTracer')
      .addEventListener('submit', function() {

        document
          .querySelectorAll(
            'input,select,textarea'
          )
          .forEach(el => {

            if (el.offsetParent === null) {
              el.required = false;
            }

          });

      });

    /*
    |--------------------------------------------------------------------------
    | Validasi
    |--------------------------------------------------------------------------
    */
    function validateCurrentSection() {
      const section =
        getVisibleSections()[currentStep];

      if (!section) {
        return true;
      }

      let valid = true;
      let firstError = null;

      section
        .querySelectorAll('.pertanyaan')
        .forEach(card => {

          if (card.style.display === 'none') {
            return;
          }

          card.querySelectorAll('[required]')
            .forEach(field => {

              if (field.type === 'radio') {
                const checked =
                  section.querySelector(
                    `[name="${field.name}"]:checked`
                  );

                if (!checked) {
                  valid = false;
                  firstError ??= card;
                }

                return;
              }

              if (field.type === 'checkbox') {
                const checked =
                  section.querySelectorAll(
                    `[name="${field.name}"]:checked`
                  );

                if (!checked.length) {
                  valid = false;
                  firstError ??= card;
                }

                return;
              }

              if (!field.value?.trim()) {
                valid = false;
                firstError ??= card;
              }
            });

        });

      if (!valid && firstError) {
        firstError.scrollIntoView({
          behavior: 'smooth',
          block: 'center'
        });

        firstError.classList.add(
          'border-danger'
        );

        setTimeout(() => {

          firstError.classList.remove(
            'border-danger'
          );

        }, 3000);
      }

      return valid;
    }

    /*
    |--------------------------------------------------------------------------
    | Navigation
    |--------------------------------------------------------------------------
    */
    function nextSection() {
      if (!validateCurrentSection()) {
        Swal.fire({
          icon: 'warning',
          title: 'Data Belum Lengkap',
          text: 'Masih ada pertanyaan wajib yang belum diisi.',
          confirmButtonColor: '#696cff'
        });

        return;
      }

      currentStep++;
      renderWizard();
    }

    function prevSection() {
      if (currentStep > 0) {
        currentStep--;
        renderWizard();
      }
    }

    /*
    |--------------------------------------------------------------------------
    | Event
    |--------------------------------------------------------------------------
    */
    document.addEventListener(
      'change',
      renderWizard
    );

    document.addEventListener(
      'DOMContentLoaded',
      renderWizard
    );
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {

      const negara = document.getElementById('negara_id');

      if (!negara) return;

      negara.addEventListener('change', function() {

        const f5a1Card =
          document.querySelector('[data-kode="F5A1"]');

        const f5a2Card =
          document.querySelector('[data-kode="F5A2"]');

        if (this.value === 'ID') {

          if (f5a1Card)
            f5a1Card.style.display = '';

        } else {

          if (f5a1Card)
            f5a1Card.style.display = 'none';

          if (f5a2Card)
            f5a2Card.style.display = 'none';
        }

      });

    });

  </script>
  <script>
    document.addEventListener('change', async function(e) {

      if (e.target.id !== 'f5a1') return;

      const provinsiId = e.target.value;
      const kotaSelect = document.getElementById('f5a2');

      if (!provinsiId) {
        kotaSelect.innerHTML =
          '<option value="">Pilih Kabupaten/Kota</option>';
        return;
      }

      kotaSelect.innerHTML =
        '<option value="">Loading...</option>';
      try {
        const response = await fetch(
          "{{ url('tracer/kota') }}/" + provinsiId
        );

        if (!response.ok) {
          throw new Error('HTTP ' + response.status);
        }

        const kotas = await response.json();

        kotaSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
        kotas.forEach(kota => {
          const option = new Option(kota.nama, kota.kode);
          kotaSelect.add(option);
        });

        // kotaSelect.innerHTML =
        //   '<option value="">Pilih Kabupaten/Kota</option>';
        // kotas.forEach(kota => {
        //   kotaSelect.innerHTML += `
        //         <option value="${kota.kode}">
        //             ${kota.nama}
        //         </option>
        //     `;
        //
        // });

      } catch (error) {
        console.error(error);
        kotaSelect.innerHTML =
          '<option value="">Gagal memuat data kota</option>';
      }
    });

    function toggleIndonesiaFields() {

      const negara = document.getElementById('negara_id');

      const cardF5A1 = document.querySelector('[data-kode="F5A1"]');
      const cardF5A2 = document.querySelector('[data-kode="F5A2"]');

      if (!negara) return;

      const isIndonesia = negara.value === 'ID';

      if (cardF5A1) {
        cardF5A1.style.display = isIndonesia ? '' : 'none';
      }

      if (cardF5A2) {
        cardF5A2.style.display = isIndonesia ? '' : 'none';
      }
    }

    // document.addEventListener('DOMContentLoaded', function() {
    //
    //   toggleIndonesiaFields();
    //
    //   const negara = document.getElementById('negara_id');
    //
    //   if (negara) {
    //     negara.addEventListener('change', toggleIndonesiaFields);
    //   }
    //
    // });
  </script>
  <script>
    document.querySelectorAll('input[type="number"]').forEach(input => {

      // Disable mouse wheel
      input.addEventListener('wheel', e => e.preventDefault());

      // Disable keyboard up/down
      input.addEventListener('keydown', e => {
        if (e.key === 'ArrowUp' || e.key === 'ArrowDown') {
          e.preventDefault();
        }
      });

    });
  </script>
  <script>
    function checkIncomeF505() {

      const rangeSelect = document.getElementById('range_F505');
      const actualInput = document.getElementById('value_F505');
      const warning = document.getElementById('warning_F505');

      if (!rangeSelect || !actualInput) {
        return true;
      }

      const selected = rangeSelect.options[rangeSelect.selectedIndex];

      const min = parseInt(selected.dataset.min || 0);
      const max = parseInt(selected.dataset.max || 999999999);

      const actual = parseInt(actualInput.value || 0);

      if (actual === 0 || rangeSelect.selectedIndex === 0) {
        warning?.classList.add('d-none');
        return true;
      }

      const valid = actual >= min && actual <= max;

      if (!valid) {
        warning?.classList.remove('d-none');
      } else {
        warning?.classList.add('d-none');
      }

      return valid;
    }

    document.querySelectorAll('.rupiah-display').forEach(input => {

      input.addEventListener('input', function() {

        let angka = this.value.replace(/\D/g, '');

        document.getElementById(
          'value_' + this.dataset.target
        ).value = angka;

        this.value = angka
          ? new Intl.NumberFormat('id-ID').format(angka)
          : '';

        if (this.dataset.target === 'F505') {
          checkIncomeF505();
        }
      });

    });

    document.getElementById('range_F505')
      ?.addEventListener('change', checkIncomeF505);

    document.querySelector('form')
      ?.addEventListener('submit', function(e) {

        if (!checkIncomeF505()) {

          e.preventDefault();

          Swal.fire({
            icon: 'warning',
            title: 'Pendapatan Tidak Sesuai',
            text: 'Rentang pendapatan yang dipilih tidak sesuai dengan pendapatan aktual.',
            confirmButtonText: 'Perbaiki'
          });

          return false;
        }
      });
  </script>
@endpush
