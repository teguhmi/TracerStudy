@extends('_include._template')

@section('content')

  @php
    $groupedSections = $sections->groupBy('section_id')->values();
  @endphp

  <form method="POST" action="{{ route('tracer.simpan') }}">
    @csrf

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
              style="width:0%"
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
              data-kode="{{ $q->kode }}"
              data-tampil-jika='@json($q->tampil_jika ?? [])'
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

                  <select
                    class="form-select"
                    name="jawaban[{{ $q->kode }}]"
                  >

                    <option value="">
                      Pilih
                    </option>

                    @foreach($q->opsi as $opsi)

                      <option value="{{ $opsi->nilai }}">
                        {{ $opsi->label }}
                      </option>

                    @endforeach

                  </select>

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
    function isSectionVisible(section)
    {
      const rule = section.dataset.rule;

      // section tanpa rule selalu tampil
      if (!rule || rule === '{}' || rule === '[]')
      {
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

            if (!checked)
            {
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
    function evaluateRules()
    {
      document
        .querySelectorAll('.pertanyaan')
        .forEach(card => {

          const rule =
            card.dataset.tampilJika;

          if (
            !rule ||
            rule === '{}' ||
            rule === '[]'
          ) {
            card.style.display = '';
            return;
          }

          try {

            const rules = JSON.parse(rule);

            const visible =
              Object.keys(rules)
                .every(field => {

                  const checked =
                    document.querySelector(
                      `[name="jawaban[${field}]"]:checked`
                    );

                  return checked &&
                    rules[field]
                      .map(String)
                      .includes(String(checked.value));

                });

            card.style.display =
              visible ? '' : 'none';

          } catch (e) {

            console.error(e);
          }

        });
    }

    /*
    |--------------------------------------------------------------------------
    | Section Tampil
    |--------------------------------------------------------------------------
    */
    function getVisibleSections()
    {
      return allSections()
        .filter(section => {

          if (!isSectionVisible(section))
          {
            const kode = section.dataset.kode;
            const rule = section.dataset.rule;

            console.log(
              'Section:',
              kode,
              'Rule:',
              rule
            );
          }

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
    function renderWizard()
    {
      evaluateRules();

      const visibleSections =
        getVisibleSections();

      if (!visibleSections.length)
      {
        return;
      }

      if (currentStep >= visibleSections.length)
      {
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

    /*
    |--------------------------------------------------------------------------
    | Validasi
    |--------------------------------------------------------------------------
    */
    function validateCurrentSection()
    {
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

          if (card.style.display === 'none')
          {
            return;
          }

          card.querySelectorAll('[required]')
            .forEach(field => {

              if(field.type === 'radio')
              {
                const checked =
                  section.querySelector(
                    `[name="${field.name}"]:checked`
                  );

                if(!checked)
                {
                  valid = false;
                  firstError ??= card;
                }

                return;
              }

              if(field.type === 'checkbox')
              {
                const checked =
                  section.querySelectorAll(
                    `[name="${field.name}"]:checked`
                  );

                if(!checked.length)
                {
                  valid = false;
                  firstError ??= card;
                }

                return;
              }

              if(!field.value?.trim())
              {
                valid = false;
                firstError ??= card;
              }
            });

        });

      if(!valid && firstError)
      {
        firstError.scrollIntoView({
          behavior:'smooth',
          block:'center'
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
    function nextSection()
    {
      if(!validateCurrentSection())
      {
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

    function prevSection()
    {
      if(currentStep > 0)
      {
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
@endpush
