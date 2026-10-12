@php use Carbon\Carbon; @endphp
@extends('_include._template')

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row g-4">

            {{-- KOLOM KIRI --}}
            <div class="col-12 col-lg-6">

                {{-- PENCARIAN --}}
                <div class="card border-primary mb-4">

                    <div class="card-body">

                        <div class="d-flex align-items-center mb-4">

                            <div class="avatar avatar-md me-3">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="ri-search-line"></i>
                            </span>
                            </div>

                            <div>
                                <h5 class="mb-1">Pencarian Alumni</h5>
                                <small class="text-muted">
                                    Masukkan NIM untuk melihat data alumni.
                                </small>
                            </div>

                        </div>

                        <form method="post" action="{{ route('ik.cari') }}">
                            @csrf

                            <div class="input-group">

                            <span class="input-group-text">
                                <i class="ri-user-search-line"></i>
                            </span>

                                <input
                                        type="text"
                                        class="form-control"
                                        id="nim"
                                        name="nim"
                                        maxlength="9"
                                        inputmode="numeric"
                                        pattern="[0-9]*"
                                        placeholder="Masukkan NIM"
                                        value="{{ old('nim') }}"
                                        required>

                                <button
                                        type="submit"
                                        class="btn btn-primary">
                                    <i class="ri-search-line me-1"></i>
                                    Tampilkan
                                </button>

                            </div>

                        </form>
                        {{-- FORM SIMPAN --}}

                    </div>

                </div>
                @if(!empty($dpYudisium))
                    @php
                        $tanggalTerima = !empty($dpYudisium->tanggal_terima_ijasah_upbjj)
                            ? Carbon::parse($dpYudisium->tanggal_terima_ijasah_upbjj)->format('Y-m-d')
                            : date('d-m-Y');

                        $showSkpi = ($dpYudisium->masa ?? 0) > 20102;
                        $showAkta = ($dpYudisium->masa ?? 0) <= 20102;
                    @endphp
                    <div class="col-12">
                        {{-- PENCARIAN --}}
                        <div class="card border-primary mb-4">

                            <div class="card-body">
                                <div class="row align-items-center">
                                    <label class="form-label fw-semibold mb-1">
                                        Tanggal Terima Ijazah
                                    </label>
                                    <div class="col-md-4">
                                        <input type="date"
                                               name="tanggal_terima"
                                               class="form-control"
                                               value="{{$tanggalTerima}}"
                                                {{ ($dpYudisium->posisi_ijasah ?? 0) > 1 ? 'readonly' : '' }}>
                                    </div>

                                    <div class="col-md-5">

                                        <div class="d-flex gap-4">

                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                       name="ijazah" id="ijazah"
                                                       value="1"
                                                        {{ ($dpYudisium->status_ijasah ?? 0) == 1 ? 'checked' : '' }}
                                                        {{ ($dpYudisium->posisi_ijasah ?? 0) > 1 ? 'disabled' : '' }}>
                                                <label class="form-check-label" for="ijazah">
                                                    Ijazah
                                                </label>
                                            </div>

                                            @if($dpYudisium->masa < 20101)
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                           name="ijazah_akta" id="ijazah_akta"
                                                           value="1"
                                                            {{ ($dpYudisium->status_ijasah_akta ?? 0) == 1 ? 'checked' : '' }}
                                                            {{ ($dpYudisium->posisi_ijasah ?? 0) > 1 ? 'disabled' : '' }}>
                                                    <label class="form-check-label" for="ijazah_akta">
                                                        Akta
                                                    </label>
                                                </div>
                                            @else
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                           name="skpi" id="skpi"
                                                           value="1"
                                                            {{ ($dpYudisium->status_ijasah_pendamping ?? 0) == 1 ? 'checked' : '' }}
                                                            {{ ($dpYudisium->posisi_ijasah ?? 0) > 1 ? 'disabled' : '' }}>
                                                    <label class="form-check-label" for="skpi">
                                                        SKPI
                                                    </label>
                                                </div>
                                            @endif
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                       name="transkrip" id="transkrip"
                                                       value="1"
                                                        {{ ($dpYudisium->status_ijasah_transkrip ?? 0) == 1 ? 'checked' : '' }}
                                                        {{ ($dpYudisium->posisi_ijasah ?? 0) > 1 ? 'disabled' : '' }} >
                                                <label class="form-check-label" for="transkrip">
                                                    Transkrip
                                                </label>
                                            </div>

                                        </div>

                                    </div>
                                    @if($dpYudisium->posisi_ijasah == 0)
                                        <div class="col-md-3">
                                            <button type="submit"
                                                    class="btn btn-success w-100">
                                                Simpan
                                            </button>
                                        </div>
                                    @else
                                        <div class="col-md-3">
                                            <button type="submit"
                                                    class="btn btn-warning w-100">
                                                Batalkan Pengambilan
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>



                    </div>
                @endif

            </div>

            {{-- KOLOM KANAN : DATA PRIBADI ALUMNI --}}

            <div class="col-12 col-lg-6">

                {{-- DATA ALUMNI --}}

                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            {{-- FOTO ALUMNI --}}
                            <div class="col-md-3 text-center mb-3 mb-md-0">

                                <img
                                        src="{{ $fotoIjazah }}"
                                        alt="Foto Alumni"
                                        class="img-fluid rounded border shadow-sm"
                                        style="max-width:150px; aspect-ratio:3/4; object-fit:cover;">

                            </div>

                            {{-- DATA ALUMNI --}}
                            <div class="col-md-9">
                                <div class="mb-2">
                                    <small class="text-muted">Nama</small>
                                    <div class="fw-bold fs-4">{{ $dpYudisium->nama_mahasiswa }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">NIM</small>
                                        <div>{{ $dpYudisium->nim }}</div>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Masa</small>
                                        <div>{{ $dpYudisium->masa }}</div>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Program Studi</small>
                                        <div>{{ $dpYudisium->nama_program_studi }}</div>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">No Surat</small>
                                        <div>{{ $dpYudisium->nomor_surat_pengiriman ?? '-' }}</div>
                                    </div>

                                    <div class="col-12">
                                        <small class="text-muted">SK Rektor</small>
                                        <div>{{ $dpYudisium->nomor_sk_rektor }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
@section('script')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const nim = document.getElementById('nim');

        if (nim) {
          nim.focus();
          nim.select();
          nim.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
          });
        }
      });
    </script>
@endsection