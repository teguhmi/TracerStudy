/**
 * Tracer Study Form Wizard & Dynamic Rules (Vite Compatible Module)
 */

export default function initTracerForm() {
  console.log('Tracer Form Initialized');

  let currentStep = 0;
  const allSections = () => [...document.querySelectorAll('.wizard-section')];

  function onReady(fn) {
    if (document.readyState !== 'loading') {
      fn();
    } else {
      document.addEventListener('DOMContentLoaded', fn);
    }
  }

  function toggleQuestion(card, visible) {
    if (!card) return;
    const inputs = card.querySelectorAll('input, select, textarea');
    card.style.display = visible ? '' : 'none';

    inputs.forEach(el => {
      if (visible) {
        if (el.dataset.required === '1' && el.type !== 'checkbox') {
          el.required = true;
        }
      } else {
        el.required = false;
        if (el.type === 'radio' || el.type === 'checkbox') {
          el.checked = false;
        }
      }
    });
  }

  /**
   * Helper Parser JSON yang Aman (Menangani String JSON ganda dari Blade)
   */
  function parseRules(ruleData) {
    if (!ruleData || ruleData === '{}' || ruleData === '[]' || ruleData === 'null') {
      return null;
    }
    try {
      let parsed = typeof ruleData === 'string' ? JSON.parse(ruleData) : ruleData;
      // Parse kedua kali jika data dalam dataset masih berupa string JSON ter-encode
      if (typeof parsed === 'string') {
        parsed = JSON.parse(parsed);
      }
      if (parsed && typeof parsed === 'object' && !Array.isArray(parsed) && Object.keys(parsed).length > 0) {
        return parsed;
      }
    } catch (e) {
      console.error('Error parsing rules:', ruleData, e);
    }
    return null;
  }

  /**
   * Evaluator Aturan Terpusat
   */
  function checkCondition(rules) {
    if (!rules) return true; // Tidak ada rule = selalu tampil

    return Object.entries(rules).every(([field, allowed]) => {
      const allowedStrings = (Array.isArray(allowed) ? allowed : [allowed]).map(String);

      // 1. Cek Radio Button
      const radio = document.querySelector(`[name="jawaban[${field}]"]:checked`);
      if (radio) {
        return allowedStrings.includes(String(radio.value));
      }

      // 2. Cek Checkbox Group
      const checkboxes = [...document.querySelectorAll(`[name="jawaban[${field}][]"]:checked`)].map(el =>
        String(el.value)
      );
      if (checkboxes.length > 0) {
        return allowedStrings.some(item => checkboxes.includes(item));
      }

      // 3. Cek Select / Input Text / Number
      const fieldEl = document.querySelector(`[name="jawaban[${field}]"]`);
      if (fieldEl && fieldEl.value !== '') {
        if (allowedStrings.length === 1 && allowedStrings[0] === '*') {
          return true;
        }
        return allowedStrings.includes(String(fieldEl.value));
      }

      // Jika pilihan syarat (misal F8) belum diisi/dilik sama sekali
      return false;
    });
  }

  function evaluateRules() {
    // 1. Evaluasi Aturan Tingkat Pertanyaan (.pertanyaan)
    document.querySelectorAll('.pertanyaan').forEach(card => {
      const ruleAttr = card.dataset.tampilJika;
      const rules = parseRules(ruleAttr);

      if (!rules) {
        toggleQuestion(card, true);
        return;
      }

      const visible = checkCondition(rules);
      toggleQuestion(card, visible);
    });

    // 2. Evaluasi Aturan Tingkat Opsi Checkbox (.opsi-wrapper)
    document.querySelectorAll('.opsi-wrapper').forEach(wrapper => {
      const ruleAttr = wrapper.dataset.opsiTampilJika;
      const rules = parseRules(ruleAttr);

      if (!rules) {
        wrapper.style.display = '';
        return;
      }

      const visible = checkCondition(rules);
      wrapper.style.display = visible ? '' : 'none';

      if (!visible) {
        const input = wrapper.querySelector('input');
        if (input) input.checked = false;
      }
    });
  }

  function getVisibleSections() {
    return allSections().filter(section => {
      return [...section.querySelectorAll('.pertanyaan')].some(card => card.style.display !== 'none');
    });
  }

  function renderWizard() {
    evaluateRules();

    const visibleSections = getVisibleSections();
    if (!visibleSections.length) return;

    if (currentStep >= visibleSections.length) {
      currentStep = visibleSections.length - 1;
    }

    allSections().forEach(section => (section.style.display = 'none'));
    visibleSections[currentStep].style.display = 'block';

    const total = visibleSections.length;
    const btnPrev = document.getElementById('btnPrev');
    const btnNext = document.getElementById('btnNext');
    const btnSubmit = document.getElementById('btnSubmit');

    if (btnPrev) btnPrev.style.display = currentStep === 0 ? 'none' : '';
    if (btnNext) btnNext.classList.toggle('d-none', currentStep >= total - 1);
    if (btnSubmit) btnSubmit.classList.toggle('d-none', currentStep < total - 1);

    const percent = Math.round(((currentStep + 1) / total) * 100);
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const stepLabel = document.getElementById('stepLabel');

    if (progressBar) progressBar.style.width = percent + '%';
    if (progressText) progressText.innerText = percent + '%';
    if (stepLabel) stepLabel.innerText = `Langkah ${currentStep + 1} dari ${total}`;
  }

  function validateCurrentSection() {
    const section = getVisibleSections()[currentStep];
    if (!section) return true;

    let valid = true;
    let firstError = null;

    section.querySelectorAll('.pertanyaan').forEach(card => {
      if (card.style.display === 'none') return;

      card.querySelectorAll('[required]').forEach(field => {
        if (field.type === 'radio') {
          const checked = section.querySelector(`[name="${CSS.escape(field.name)}"]:checked`);
          if (!checked) {
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

      const requiredCheckboxes = card.querySelectorAll('input[type="checkbox"][data-required="1"]');
      if (requiredCheckboxes.length > 0) {
        const isAnyChecked = [...requiredCheckboxes].some(cb => cb.checked);
        if (!isAnyChecked) {
          valid = false;
          firstError ??= card;
        }
      }
    });

    if (!valid && firstError) {
      firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
      firstError.classList.add('border-danger');
      setTimeout(() => firstError.classList.remove('border-danger'), 3000);
    }

    return valid;
  }

  function nextSection() {
    if (!validateCurrentSection()) {
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          icon: 'warning',
          title: 'Data Belum Lengkap',
          text: 'Masih ada pertanyaan wajib yang belum diisi.',
          confirmButtonColor: '#696cff'
        });
      } else {
        alert('Masih ada pertanyaan wajib yang belum diisi.');
      }
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

  function toggleIndonesiaFields() {
    const negara = document.getElementById('negara_id');
    const isIndonesia = negara?.value === 'ID';
    ['F5A1', 'F5A2'].forEach(kode => {
      const el = document.querySelector(`[data-kode="${kode}"]`);
      if (el) toggleQuestion(el, isIndonesia);
    });
  }

  function checkIncomeF505() {
    const rangeSelect = document.getElementById('range_F505');
    const actualInput = document.getElementById('value_F505');
    const warning = document.getElementById('warning_F505');

    if (!rangeSelect || !actualInput) return true;

    const selected = rangeSelect.options[rangeSelect.selectedIndex];
    if (!selected || rangeSelect.selectedIndex === 0) {
      warning?.classList.add('d-none');
      return true;
    }

    const min = parseInt(selected.dataset.min || 0);
    const max = parseInt(selected.dataset.max || 999999999);
    const actual = parseInt(actualInput.value || 0);

    if (actual === 0) {
      warning?.classList.add('d-none');
      return true;
    }

    const valid = actual >= min && actual <= max;
    warning?.classList.toggle('d-none', valid);
    return valid;
  }

  window.nextSection = nextSection;
  window.prevSection = prevSection;
  window.renderWizard = renderWizard;

  document.addEventListener('change', evaluateRules);

  onReady(function () {
    renderWizard();
    toggleIndonesiaFields();

    document.getElementById('btnNext')?.addEventListener('click', nextSection);
    document.getElementById('btnPrev')?.addEventListener('click', prevSection);

    const negara = document.getElementById('negara_id');
    if (negara) {
      negara.addEventListener('change', toggleIndonesiaFields);
    }

    document.getElementById('formTracer')?.addEventListener('submit', function (e) {
      document.querySelectorAll('input, select, textarea').forEach(el => {
        if (el.offsetParent === null) {
          el.required = false;
        }
      });

      if (!checkIncomeF505()) {
        e.preventDefault();
        if (typeof Swal !== 'undefined') {
          Swal.fire({
            icon: 'warning',
            title: 'Pendapatan Tidak Sesuai',
            text: 'Rentang pendapatan yang dipilih tidak sesuai dengan pendapatan aktual.',
            confirmButtonText: 'Perbaiki'
          });
        } else {
          alert('Rentang pendapatan yang dipilih tidak sesuai dengan pendapatan aktual.');
        }
        return false;
      }
    });

    document.querySelectorAll('input[type="number"]').forEach(input => {
      input.addEventListener('wheel', e => e.preventDefault());
      input.addEventListener('keydown', e => {
        if (e.key === 'ArrowUp' || e.key === 'ArrowDown') e.preventDefault();
      });
    });

    document.querySelectorAll('.rupiah-display').forEach(input => {
      input.addEventListener('input', function () {
        let angka = this.value.replace(/\D/g, '');
        const targetInput = document.getElementById('value_' + this.dataset.target);
        if (targetInput) targetInput.value = angka;
        this.value = angka ? new Intl.NumberFormat('id-ID').format(angka) : '';

        if (this.dataset.target === 'F505') checkIncomeF505();
      });
    });

    document.getElementById('range_F505')?.addEventListener('change', checkIncomeF505);

    const provinsiSelect = document.getElementById('f5a1');
    const kotaSelect = document.getElementById('f5a2');
    const kotaBaseUrl = window.tracerConfig?.kotaUrl || '/tracer/kota';

    if (provinsiSelect && kotaSelect) {
      async function loadKota(provinsiId) {
        kotaSelect.innerHTML = '<option value="">Loading...</option>';
        try {
          const response = await fetch(`${kotaBaseUrl}/${provinsiId}`);
          const kotas = await response.json();

          kotaSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
          kotas.forEach(function (kota) {
            kotaSelect.innerHTML += `<option value="${kota.kode}">${kota.nama}</option>`;
          });

          const selectedKota = kotaSelect.dataset.selected;
          if (selectedKota) {
            kotaSelect.value = String(selectedKota);
          }
        } catch (err) {
          console.error(err);
          kotaSelect.innerHTML = '<option value="">Gagal memuat data kota</option>';
        }
      }

      provinsiSelect.addEventListener('change', function () {
        if (this.value) loadKota(this.value);
      });

      if (provinsiSelect.value) loadKota(provinsiSelect.value);
    }
  });

  if (typeof jQuery !== 'undefined') {
    $(function () {
      const $bio05 = $('#bio05');
      const $bio06 = $('#bio06');
      const $bio07 = $('#bio07');

      if ($bio05.length) {
        $.get('/ajax/negaras', function (data) {
          let html = '<option value="">Pilih Negara</option>';
          $.each(data, function (i, item) {
            html += `<option value="${item.id}">${item.nama_negara}</option>`;
          });
          $bio05.html(html);

          let selectedNegara = $bio05.data('selected');
          if (selectedNegara) {
            $bio05.val(String(selectedNegara));
            setTimeout(() => {
              $bio05.trigger('change');
              renderWizard();
            }, 100);
          }
        });
      }

      $(document).on('change', '#bio05', function () {
        let negaraId = $(this).val();
        $bio06.html('<option value="">Pilih Provinsi</option>');
        $bio07.html('<option value="">Pilih Kabupaten/Kota</option>');
        if (!negaraId) return;

        $.get('/ajax/provinsis/' + negaraId, function (data) {
          let html = '<option value="">Pilih Provinsi</option>';
          $.each(data, function (i, item) {
            html += `<option value="${item.id}">${item.nama_provinsi}</option>`;
          });
          $bio06.html(html);

          let selectedProvinsi = $bio06.data('selected');
          if (selectedProvinsi) {
            $bio06.val(String(selectedProvinsi));
            setTimeout(() => {
              $bio06.trigger('change');
            }, 100);
          }
        });
      });

      $(document).on('change', '#bio06', function () {
        let provinsiId = $(this).val();
        $bio07.html('<option value="">Pilih Kabupaten/Kota</option>');
        if (!provinsiId) return;

        $.get('/ajax/kabupaten-kotas/' + provinsiId, function (data) {
          let html = '<option value="">Pilih Kabupaten/Kota</option>';
          $.each(data, function (i, item) {
            html += `<option value="${item.id}">${item.nama_kabupaten_kota}</option>`;
          });
          $bio07.html(html);

          let selectedKota = $bio07.data('selected');
          if (selectedKota) {
            $bio07.val(String(selectedKota));
          }
        });
      });

      let nilai = parseInt($('#value_F505').val() || 0);
      $('#range_F505 option').each(function () {
        let min = parseInt($(this).data('min'));
        let max = parseInt($(this).data('max'));
        if (nilai >= min && nilai <= max) {
          $(this).prop('selected', true);
          return false;
        }
      });
    });
  }
}
