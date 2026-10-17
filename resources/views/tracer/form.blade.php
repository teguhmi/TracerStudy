@extends('_include._template')

@section('content')

  @php
    $groupedSections = $sections->groupBy('section_id')->values();
  @endphp

  <form id="tracerForm" method="POST" action="{{ route('tracer.simpan') }}">
    @csrf
    <input type="hidden" name="aksi" id="aksi" value="submit">

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

      @foreach($groupedSections as $sectionIndex => $sectionQuestions)

        @php
          $firstQuestion = $sectionQuestions->first();
        @endphp

        <div
          class="wizard-section"
          id="section-{{ $sectionIndex }}"
          data-kode="{{ $firstQuestion->section->kode }}"
          data-rule='@json($firstQuestion->section->tampil_jika ?? [])'
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
              data-tampil-jika='@json($q->tampil_jika ?? [])'
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
                  >

                  {{-- TEXTAREA --}}
                @elseif($q->jenis == 'textarea')

                  <textarea
                    class="form-control"
                    rows="3"
                    name="jawaban[{{ $q->kode }}]"
                    placeholder="{{ $q->placeholder }}"
                  ></textarea>

                  {{-- NUMBER --}}
                @elseif($q->jenis == 'number')

                  <input
                    type="number"
                    class="form-control"
                    name="jawaban[{{ $q->kode }}]"
                  >

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

                          <input
                            type="checkbox"
                            class="form-check-input me-2"
                            name="jawaban[{{ $q->kode }}][]"
                            value="{{ $opsi->nilai }}"
                          >

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

                    @case('F510')
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

                        @foreach($provinsis as $provinsi)
                          <option value="{{ $provinsi->kode }}">
                            {{ $provinsi->nama }}
                          </option>
                        @endforeach
                      </select>


                      @break

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
      <div class="sticky-bottom bg-white py-3 border-top">

        <div class="d-flex justify-content-between">

          <button
            type="button"
            id="btnPrev"
            class="btn btn-outline-secondary"
            onclick="prevSection()"
          >
            ← Previous
          </button>

          <button
            type="button"
            id="btnNext"
            class="btn btn-primary"
            onclick="nextSection()"
          >
            Next →
          </button>

          <button
            type="submit"
            id="btnSubmit"
            class="btn btn-success d-none"
          >
            Simpan Jawaban
          </button>

        </div>

      </div>

    </div>
  </form>
@endsection

@push('css')
  <style>

    .option-card {
      display: flex;
      align-items: center;
      gap: 10px;
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 12px;
      cursor: pointer;
      width: 100%;
      transition: .2s;
    }

    .option-card:hover {
      background: #f8f9fa;
      border-color: #696cff;
    }

  </style>
@endpush

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endpush
@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



  <script>

    let currentStep = 0;
    /*
    |--------------------------------------------------------------------------
    | Utility
    |--------------------------------------------------------------------------
    */
    const allSections = () =>
      [...document.querySelectorAll('.wizard-section')];
  </script>
  <script>
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
  </script>
  <script>
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
  </script>
  <script>
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
  </script>
  <script>
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
  </script>
  <script>

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
  </script>
  <script>


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
  </script>
  <script>
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
  </script>
  <script>
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
  </script>
  <script>
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

        if (this.value == 'ID') {

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

        kotaSelect.innerHTML =
          '<option value="">Pilih Kabupaten/Kota</option>';
        kotas.forEach(kota => {
          kotaSelect.innerHTML += `
                <option value="${kota.kode}">
                    ${kota.nama}
                </option>
            `;

        });

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

    document.addEventListener('DOMContentLoaded', function() {

      toggleIndonesiaFields();

      const negara = document.getElementById('negara_id');

      if (negara) {
        negara.addEventListener('change', toggleIndonesiaFields);
      }

    });
  </script>

@endpush
