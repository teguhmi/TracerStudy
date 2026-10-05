@extends('_include._template')
@section('content')

    <div class="container-xxl grow container-p-y">
        <!-- Card Border Shadow -->
        <div class="row g-6">
            <div class="col-sm-6 col-lg-3">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                          <span class="avatar-initial rounded-3 bg-label-primary"
                          ><i class="icon-base ri ri-car-line icon-24px"></i
                              ></span>
                            </div>
                            <h4 class="mb-0">42</h4>
                        </div>
                        <h6 class="mb-0 fw-normal">Antrian Validasi Berkas (UT Pusat)</h6>
                        <p class="mb-0">
                            <span class="me-1 fw-medium">3400</span>
                            <small class="text-body-secondary">Belum unggah berkas</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-border-shadow-warning h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                          <span class="avatar-initial rounded-3 bg-label-warning"
                          ><i class="icon-base ri ri-alert-line icon-24px"></i
                              ></span>
                            </div>
                            <h4 class="mb-0">8</h4>
                        </div>
                        <h6 class="mb-0 fw-normal">Antrian Validasi Berkas (UT Daerah)</h6>
                        <p class="mb-0">
                            <span class="me-1 fw-medium">3400</span>
                            <small class="text-body-secondary">Belum unggah foto</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-border-shadow-danger h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                          <span class="avatar-initial rounded-3 bg-label-danger"
                          ><i class="icon-base ri ri-route-line icon-24px"></i
                              ></span>
                            </div>
                            <h4 class="mb-0">27</h4>
                        </div>
                        <h6 class="mb-0 fw-normal">Antrian Validasi Foto</h6>
                        <p class="mb-0">
                            <span class="me-1 fw-medium">3500</span>
                            <small class="text-body-secondary">Belum unggah foto</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-border-shadow-info h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                          <span class="avatar-initial rounded-3 bg-label-info"
                          ><i class="icon-base ri ri-time-line icon-24px"></i
                              ></span>
                            </div>
                            <h4 class="mb-0">13</h4>
                        </div>
                        <h6 class="mb-0 fw-normal">Gagal Validasi</h6>
                        <p class="mb-0">
                            <span class="me-1 fw-medium">Berkas (20) Foto (10)</span>
                            <small class="text-body-secondary"></small>
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
                                    <li class="nav-item">
                                        <button
                                                class="nav-link active"
                                                data-bs-toggle="tab"
                                                data-bs-target="#tab-1"
                                                role="tab"
                                                aria-selected="true">
                                            <span class="icon-base ri ri-user-line d-sm-none"></span>
                                            <span class="d-none d-sm-block">Validasi Berkas UT Pusat</span>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button
                                                class="nav-link"
                                                data-bs-toggle="tab"
                                                data-bs-target="#tab-2"
                                                role="tab"
                                                aria-selected="false">
                                            <span class="icon-base ri ri-folder-user-line d-sm-none"></span>
                                            <span class="d-none d-sm-block">Validasi Berkas UT Daerah</span>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button
                                                class="nav-link"
                                                data-bs-toggle="tab"
                                                data-bs-target="#tab-3"
                                                role="tab"
                                                aria-selected="false">
                                            <span class="icon-base ri ri-facebook-circle-fill d-sm-none"></span>
                                            <span class="d-none d-sm-block">Validasi Foto</span>
                                        </button>
                                    </li>

                                    <li class="nav-item">
                                        <button
                                                class="nav-link"
                                                data-bs-toggle="tab"
                                                data-bs-target="#tab-4"
                                                role="tab"
                                                aria-selected="false">
                                            <span class="icon-base ri ri-facebook-circle-fill d-sm-none"></span>
                                            <span class="d-none d-sm-block">Gagal Validasi Berkas</span>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button
                                                class="nav-link"
                                                data-bs-toggle="tab"
                                                data-bs-target="#tab-5"
                                                role="tab"
                                                aria-selected="false">
                                            <span class="icon-base ri ri-facebook-circle-fill d-sm-none"></span>
                                            <span class="d-none d-sm-block">Gagal Validasi Foto</span>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="tab-1" role="tabpanel">
                                    @include('content.pages.kelulusan.kelulusan-DT-validasi-berkas-pusat')
                                </div>
                                <div class="tab-pane fade" id="tab-2" role="tabpanel">
                                    @include('content.pages.kelulusan.kelulusan-DT-validasi-berkas-pusat')
                                </div>
                                <div class="tab-pane fade" id="tab-3" role="tabpanel">
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
                                <div class="tab-pane fade" id="tab-4" role="tabpanel">
                                    <div class="card-datatable table-responsive">
                                        <table id="gagalberkas"
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
                                <div class="tab-pane fade" id="tab-5" role="tabpanel">
                                    <div class="card-datatable table-responsive">

                                        <table id="gagalfoto"
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <
    <script>
      $(document).ready(function() {

        // ============================================
        // FUNCTION DATATABLE KELULUSAN
        // ============================================
        function initKelulusanTable(tableId, flagFoto) {

          return $(tableId).DataTable({
            processing: true,
            serverSide: true,

            ajax: {
              url: "{{ route('kelulusan.data') }}",
              type: "GET",

              // Kirim flag_foto ke Controller
              data: function(d) {
                d.flag_foto = flagFoto;
              }
            },

            columns: [
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
                orderable: false,
                searchable: false,

                render: function(data, type, row) {
                  return `<a href="/kelulusan/detail/${data}" class="btn btn-sm btn-primary"> Detail</a>`;
                }
              }
            ],

            pageLength: 25,
            lengthMenu: [
              [10, 25, 50, 100],
              [10, 25, 50, 100]
            ],
            order: []
          });
        }

        const tableFotoValid = initKelulusanTable(
          '#fotovalid', 1
        );

        const tableFotoGagal = initKelulusanTable(
          '#gagalfoto', 3
        );

        $('button[data-bs-toggle="tab"], a[data-bs-toggle="tab"]').on(
          'shown.bs.tab',
          function() {
            $.fn.dataTable
              .tables({
                visible: true,
                api: true
              })
              .columns
              .adjust();
          }
        );
      });
    </script>

@endsection

