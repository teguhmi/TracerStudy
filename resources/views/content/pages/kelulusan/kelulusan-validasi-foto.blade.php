@extends('_include._template')
@section('content')
    <div id="kelulusan-config"
         data-url="{{ route('kelulusan.foto.data') }}"
         data-detail-url="{{ url('/kelulusan/detail') }}"
         class="d-none">
    </div>
    <div class="container-fluid flex-grow-1 container-p-y">
        <!-- Card Border Shadow -->
        <div class="row g-6">

            <div class="col-sm-6 col-lg-4">
                <div class="card card-border-shadow-warning h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                          <span class="avatar-initial rounded-3 bg-label-warning"
                          ><i class="icon-base ri ri-alert-line icon-24px"></i
                              ></span>
                            </div>
                            <h4 class="mb-0">{{ number_format($statistik->proses_validasi ?? 0) }}</h4>
                        </div>
                        <h6 class="mb-0 fw-normal">Antrian Validasi Foto</h6>
                        <p class="mb-0">
                            <span class="me-1 fw-medium">Proses 10 %</span>
                            <small class="text-body-secondary">jumlah lulusan 200</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="card card-border-shadow-danger h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                          <span class="avatar-initial rounded-3 bg-label-danger"
                          ><i class="icon-base ri ri-route-line icon-24px"></i
                              ></span>
                            </div>
                            <h4 class="mb-0">{{ number_format($statistik->belum_unggah ?? 0) }}</h4>
                        </div>
                        <h6 class="mb-0 fw-normal">Belum Unggah Foto</h6>
                        <p class="mb-0">
                            <span class="me-1 fw-medium">3500</span>
                            <small class="text-body-secondary">Belum unggah foto</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="card card-border-shadow-info h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                          <span class="avatar-initial rounded-3 bg-label-info"
                          ><i class="icon-base ri ri-time-line icon-24px"></i
                              ></span>
                            </div>
                            <h4 class="mb-0"> <h4 class="mb-0">{{ number_format($statistik->gagal_validasi ?? 0) }}</h4></h4>
                        </div>
                        <h6 class="mb-0 fw-normal">Gagal Validasi Foto</h6>
                        <p class="mb-0">

                            <span class="me-1 fw-medium">30</span>
                            <small class="text-body-secondary">Gagal validasi</small>
                        </p>
                    </div>
                </div>
            </div>

            <!-- On route vehicles Table -->
            <div class="col-12 ">
                <div class="row">

                    <div class="col">
                        <div class="card mb-6">
                            <div class="card-header nav-align-top p-0 pb-6">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item ">
                                        <button
                                            class="nav-link active"
                                            data-bs-toggle="tab"
                                            data-bs-target="#tab-1"
                                            role="tab"
                                            aria-selected="false">
                                            <span class="icon-base ri ri-facebook-circle-fill d-sm-none"></span>
                                            <span class="d-none d-sm-block">Validasi Foto UT Daerah</span>
                                        </button>
                                    </li>

                                    <li class="nav-item">
                                        <button
                                            class="nav-link"
                                            data-bs-toggle="tab"
                                            data-bs-target="#tab-2"
                                            role="tab"
                                            aria-selected="false">
                                            <span class="icon-base ri ri-facebook-circle-fill d-sm-none"></span>
                                            <span class="d-none d-sm-block">Gagal Validasi Foto</span>
                                        </button>
                                    </li>

                                    <li class="nav-item">
                                        <button
                                            class="nav-link "
                                            data-bs-toggle="tab"
                                            data-bs-target="#tab-3"
                                            role="tab"
                                            aria-selected="true">
                                            <span class="icon-base ri ri-user-line d-sm-none"></span>
                                            <span class="d-none d-sm-block">Belum Unggah</span>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="tab-1" role="tabpanel">
                                    <div class="card-datatable table-responsive">

                                        <table id="fotovalid"
                                               class="table table-bordered"
                                               style="width:100%">

                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>NIM</th>
                                                <th>SK Rektor</th>
                                                <th>UT Daerah</th>
                                                <th>Foto</th>
                                                <th>Status</th>
                                                <th>Opsi</th>
                                            </tr>
                                            </thead>

                                            <tbody></tbody>

                                        </table>

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-2" role="tabpanel">
                                    <div class="card-datatable table-responsive">
                                    <table id="fotogagal"
                                           class="table table-bordered"
                                           style="width:100%">

                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>NIM</th>
                                            <th>Nomor SK Rektor</th>
                                            <th>Keterangan</th>
                                            <th>UT Daerah</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>

                                        <tbody></tbody>

                                    </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-3" role="tabpanel">
                                    <table id="fotobelum"
                                           class="table table-bordered"
                                           style="width:100%">

                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>NIM</th>
                                            <th>Nomor SK Rektor</th>
                                            <th>UT Daerah</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>

                                        <tbody></tbody>

                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab-4" role="tabpanel">

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
    <script type="module">
        $(document).ready(function () {

            // =====================================================
            // VARIABEL DATATABLE
            // =====================================================

            let tableFotoValid = null;
            let tableFotoGagal = null;
            let tableBelumFoto = null;


            // =====================================================
            // FUNCTION DATATABLE GENERIK
            // =====================================================

            function initKelulusanTable(tableId, flagFoto, columns) {

                return $(tableId).DataTable({

                    processing: true,
                    serverSide: true,

                    ajax: {
                        url: "{{ route('kelulusan.foto.data') }}",
                        type: "GET",

                        data: function (d) {

                            // parameter yang dikirim ke Laravel
                            d.flag_foto = flagFoto;
                        }
                    },

                    columns: columns,

                    pageLength: 25,

                    lengthMenu: [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],

                    order: [],

                    responsive: false,

                    autoWidth: false
                });
            }


            // =====================================================
            // TABLE 1
            // FOTO VALID
            // flag_foto = 1
            // =====================================================

            const columnsFotoValid = [

                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },

                {
                    data: 'nama_mahasiswa',
                    name: 'nama_mahasiswa'
                },

                {
                    data: 'nim',
                    name: 'nim'
                },

                {
                    data: 'nomor_sk_rektor',
                    name: 'nomor_sk_rektor'
                },

                {
                    data: 'nama_upbjj',
                    name: 'nama_upbjj'
                },

                {
                    data: 'flag_foto',
                    name: 'flag_foto'
                },

                {
                    data: 'flag_dp',
                    name: 'flag_dp'
                },

                {
                    data: 'nim',
                    name: 'nim',

                    searchable: false,
                    orderable: false,

                    render: function (data, type, row) {

                        return `
                    <a
                        href="/kelulusan/detail/${data}"
                        class="btn btn-sm btn-primary">

                        Detail

                    </a>
                `;
                    }
                }

            ];


            // =====================================================
            // TABLE 2
            // FOTO GAGAL
            // flag_foto = 3
            // =====================================================

            const columnsFotoGagal = [

                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'nama_mahasiswa',
                    name: 'nama_mahasiswa'
                },
                {
                    data: 'nim',
                    name: 'nim'
                },
                {
                    data: 'nomor_sk_rektor',
                    name: 'nomor_sk_rektor'
                },
                {
                    data: 'info',
                    name: 'info'
                },
                {
                    data: 'nama_upbjj',
                    name: 'nama_upbjj'
                },

                {
                    data: 'flag_foto',
                    name: 'flag_foto',

                    render: function (data) {

                        if (data === 3) {

                            return `
                        <span class="badge bg-danger">
                            Gagal Validasi
                        </span>
                    `;
                        }

                        return data;
                    }
                },

                {
                    data: 'nim',
                    name: 'nim',

                    searchable: false,
                    orderable: false,

                    render: function (data, type, row) {

                        return `
                    <a
                        href="/kelulusan/detail/${data}"
                        class="btn btn-sm btn-danger">

                        Periksa

                    </a>
                `;
                    }
                }

            ];


            // =====================================================
            // TABLE 3
            // BELUM UPLOAD FOTO
            // flag_foto = 0
            // =====================================================

            const columnsBelumFoto = [

                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'nama_mahasiswa',
                    name: 'nama_mahasiswa'
                },
                {
                    data: 'nim',
                    name: 'nim'
                },
                {
                    data: 'nomor_sk_rektor',
                    name: 'nomor_sk_rektor'
                },
                {
                    data: 'nama_upbjj',
                    name: 'nama_upbjj'
                },


                {
                    data: 'nim',
                    name: 'nim',

                    searchable: false,
                    orderable: false,

                    render: function (data, type, row) {

                        return `
                    <a
                        href="/kelulusan/detail/${data}"
                        class="btn btn-sm btn-warning">

                        Detail

                    </a>
                `;
                    }
                }

            ];


            // =====================================================
            // LOAD TABLE PERTAMA
            // =====================================================

            tableFotoValid = initKelulusanTable(
                '#fotovalid',
                1,
                columnsFotoValid
            );


            // =====================================================
            // EVENT TAB
            // =====================================================

            $('button[data-bs-toggle="tab"]').on(
                'shown.bs.tab',
                function (e) {

                    const target = $(e.target).data('bs-target');


                    // =================================================
                    // TAB 1
                    // =================================================

                    if (target === '#tab-1') {

                        if (tableFotoValid === null) {

                            tableFotoValid = initKelulusanTable(
                                '#fotovalid',
                                1,
                                columnsFotoValid
                            );

                        } else {

                            tableFotoValid
                                .columns
                                .adjust();
                        }

                    }


                    // =================================================
                    // TAB 2
                    // =================================================

                    if (target === '#tab-2') {

                        if (tableFotoGagal === null) {

                            tableFotoGagal = initKelulusanTable(
                                '#fotogagal',
                                3,
                                columnsFotoGagal
                            );

                        } else {

                            tableFotoGagal
                                .columns
                                .adjust();
                        }

                    }


                    // =================================================
                    // TAB 3
                    // =================================================

                    if (target === '#tab-3') {

                        if (tableBelumFoto === null) {

                            tableBelumFoto = initKelulusanTable(
                                '#fotobelum',
                                0,
                                columnsBelumFoto
                            );

                        } else {

                            tableBelumFoto
                                .columns
                                .adjust();
                        }

                    }

                }
            );

        });
    </script>

@endsection

