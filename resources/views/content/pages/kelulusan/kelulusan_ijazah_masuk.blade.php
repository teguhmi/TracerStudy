@extends('_include._template')

@section('content')

    <div class="row">

        {{-- KOLOM KIRI --}}
        <div class="col s12 l4">

            {{-- FORM PENCARIAN --}}
            <div class="card">
                <div class="card-content">

                <span class="card-title">
                    Masukkan NIM
                </span>

                    <form method="POST" action="{{route('im.cari')}}">
                        @csrf

                        <div class="row">

                            <div class="input-field col s12 m8">
                                <input
                                        type="text"
                                        id="nim"
                                        name="nim"
                                        value="{{ old('nim') }}"
                                        required
                                >
                                <label for="nim">NIM</label>
                            </div>

                            <div class="input-field col s12 m4">
                                <button
                                        type="submit"
                                        class="btn waves-effect waves-light green">
                                    <i class="material-icons left">search</i>
                                    Cari
                                </button>
                            </div>

                        </div>

                    </form>

                </div>
            </div>

            @if(!empty($dpYudisium))

                {{-- DATA ALUMNI --}}
                <div class="card">
                    <div class="card-content">

                    <span class="card-title">
                        Data Alumni
                    </span>

                        <table class="striped">
                            <tbody>

                            <tr>
                                <th width="35%">NIM</th>
                                <td>: {{ $dpYudisium->nim }}</td>
                            </tr>

                            <tr>
                                <th>Nama</th>
                                <td>: {{ $dpYudisium->nama_mahasiswa }}</td>
                            </tr>

                            <tr>
                                <th>Program Studi</th>
                                <td>: {{ $dpYudisium->program_studi }}</td>
                            </tr>

                            <tr>
                                <th>Nomor Surat Pengiriman</th>
                                <td>: {{ $dpYudisium->nomor_surat_pengiriman }}</td>
                            </tr>

                            <tr>
                                <th>Nomor SK Rektor</th>
                                <td>: {{ $dpYudisium->nomor_sk_rektor }}</td>
                            </tr>

                            </tbody>
                        </table>

                    </div>
                </div>

            @endif

        </div>

        {{-- KOLOM KANAN --}}
        <div class="col s12 l8">

            @if(!empty($daftarLulusan))

                <div class="card">
                    <div class="card-content">

                    <span class="card-title">
                        Daftar Lulusan SK Rektor
                        {{ $dpYudisium->nomor_sk_rektor }}
                    </span>

                        <div style="max-height:650px; overflow-y:auto;">

                            <table class="highlight striped">

                                <thead>
                                <tr>
                                    <th width="60">No</th>
                                    <th>NIM</th>
                                    <th>Nama Mahasiswa</th>
                                    <th width="80">Urut</th>
                                </tr>
                                </thead>

                                <tbody>

                                @forelse($daftarLulusan as $item)

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nim }}</td>
                                        <td>{{ $item->nama_mahasiswa }}</td>
                                        <td>{{ $item->urut }}</td>
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="4" class="center-align">
                                            Tidak ada data
                                        </td>
                                    </tr>

                                @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>
                </div>

            @endif

        </div>

    </div>

@endsection