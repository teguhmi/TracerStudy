import './bootstrap';
/*
  Add custom scripts here
*/
import.meta.glob([
  '../assets/img/**',
  // '../assets/json/**',
  '../assets/vendor/fonts/**'
]);

import Swal from 'sweetalert2';
window.Swal = Swal;

import initTracerForm from './tracer_form.js';

// Jalankan form tracer saat halaman memuat form tracer
if (document.querySelector('#formTracer')) {
  initTracerForm();
}
