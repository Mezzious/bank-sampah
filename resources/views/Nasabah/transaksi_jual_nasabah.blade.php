@extends('layout.app_nasabah')

@section('content')
    <div class="main">
        <div class="page-heading">
            <div class="row">
                <div class="d-flex align-items-center justify-content-between ">
                    <h2 class="h2 mb-0 col-4 col-md-2 text-gray-800">Transaksi Jual Sampah</h2>
                    <div class="d-flex align-items-center">
                        <!-- Menu for larger screens -->
                        <div class="d-none d-md-flex align-items-center">
                            <div class="dropdown">
                                <a href="#" id="topbarUserDropdown"
                                    class="user-dropdown d-flex align-items-center dropend dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="text">
                                        <h6 class="user-dropdown-name">Selamat Datang, {{ auth()->user()->name }}</h6>
                                        <p class="user-dropdown-status text-sm text-muted"></p>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-center shadow-lg text-center p-3"
                                    aria-labelledby="topbarUserDropdown" style="border-radius: 10px;">
                                    <li>
                                        <a class="btn btn-block btn-custom mb-2" style="border-radius: 8px;"
                                            href="{{ route('ganti_password_nasabah') }}">
                                            <i class="bi bi-key-fill"></i> Password
                                        </a>
                                    </li>
                                    <li>
                                        <form method="get" action="{{ route('logout') }}">
                                            <input type="hidden" name="_token"
                                                value="Fp6EQq2SXZNoCNVF3DWv21fbnsh5DCjvA7Bgx5UK">
                                            <span class="text-black d-grid gap-5">
                                                <button class="btn btn-danger" type="submit" style="border-radius: 8px;">
                                                    <i class="bi bi-box-arrow-left"></i> Logout
                                                </button>
                                            </span>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Hamburger menu for smaller screens -->
                        <div class="d-md-none ms-2">
                            <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu"
                                aria-controls="offcanvasMenu">
                                <i class="bi bi-person-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Offcanvas Menu for smaller screens -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel">Selamat Datang, {{ auth()->user()->name }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="text-center">
                <a class="btn btn-block btn-custom mb-2" style="border-radius: 8px;"
                    href="{{ route('ganti_password_admin') }}">
                    <i class="bi bi-key-fill"></i> Ganti Password
                </a>
                <form method="get" action="{{ route('logout') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button class="btn btn-danger w-100" type="submit" style="border-radius: 8px;">
                        <i class="bi bi-box-arrow-left"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>


    <link rel="stylesheet" href="./assets/compiled/css/all.view.css">
    <link rel="stylesheet" href="./assets/compiled/css/dataTables.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/5Bl1xZoDvj3FVBIpT9SNq9u/KfAZ5qON6lC7G" crossorigin="anonymous">

    <div class="back-button-container" style="margin-bottom: 10px">
        <a class="btn back-button" onclick="goBack()">
            <i class="fa-solid fa-arrow-left" style="color: white;"></i>
            <span style="color: white;">Back</span>
        </a>
    </div>

    <form action="{{ route('tampilkan_tanggal_transaksi_nasabah') }}" method="post" name="form10">
        @csrf
        <div class="row">
            <div class="col-lg-3">
                <input name="txtTglAwal" id="txtTglAwal" type="date" class="form-control" size="10" />
            </div>
            <div class="col-lg-3">
                <input name="txtTglAkhir" id="txtTglAkhir" type="date" class="form-control" size="10" />
            </div>
            <div class="col-lg-3">
                <input name="btnTampil" style="color: white" class="btn btn-custom" type="submit" value="Tampilkan" />
            </div>
        </div>
    </form>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
        </div>
    @endif

    @if (isset($saleses))
        <div class="mb-3"></div>
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table_nasabah" class="table table-bordered">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Jual</th>
                                        <th>Jenis Sampah</th>
                                        <th>Gambar</th>
                                        <th>Berat (Kg)</th>
                                        <th>Harga (Rp)</th>
                                        <th>Total (Rp)</th>
                                        <th>TTD</th>
                                        <th>Status Konfirmasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($saleses as $sales)
                                        <tr>
                                            <td> {{ $loop->iteration }} </td>
                                            <td> {{ $sales->tanggal_jual }} </td>
                                            <td> {{ $sales->jenis_sampah }} </td>
                                            <td><img src="{{ asset('storage/assets/sampah_penjualan/' . $sales->gambar_sampah) }}"
                                                    width="60px" height="60px"></td>
                                            <td> {{ $sales->berat }}</td>
                                            <td> {{ $sales->harga }} </td>
                                            <td> {{ $sales->total }} </td>
                                            <td style="text-align: center">
                                                <a href="#" class="btn btn-primary btn-sm" style="color: white"
                                                    onclick="showNotaImage('{{ asset('storage/assets/tanda_tangan_jual/' . $sales->gambar_ttd) }}')">
                                                    <i class="bi bi-eye-fill"></i>
                                                </a>
                                            </td>
                                            <td style="text-align: center;">
                                                @if ($sales->status_konfirmasi == 'belum dikonfirmasi')
                                                    <span class="badge bg-danger">Belum Dikonfirmasi</span>
                                                @elseif($sales->status_konfirmasi == 'sedang dijemput')
                                                    <span class="badge bg-warning">Sedang Dijemput</span>
                                                @elseif($sales->status_konfirmasi == 'sampah telah diterima')
                                                    <span class="badge bg-info">Sampah Telah Diterima</span>
                                                @elseif($sales->status_konfirmasi == 'sudah dikonfirmasi')
                                                    <span class="badge bg-success">Sudah Dikonfirmasi</span>
                                                @endif
                                            </td>
                                            <td style="text-align: center;">
                                                <a href="{{ route('edit_transaksi_jual_nasabah', ['id' => $sales->id]) }}"
                                                    class="btn btn-warning btn-sm" style="color: white">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn btn-danger btn-sm deleteButton"
                                                    data-id="{{ $sales->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <form id="delete-form-{{ $sales->id }}"
                                                    action="{{ route('destroy_transaksi_jual_nasabah', $sales->id) }}"
                                                    method="get" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <br>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('tambah_transaksi_jual_nasabah') }}" class="btn btn-custom">
                                    <i class="fa-solid fa-cart-plus" style="color: white; margin-right: 5px;"></i>
                                    <span style="color: white;">Tambah</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="gambarNotaModal" tabindex="-1" aria-labelledby="gambarNotaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gambarNotaModalLabel">Gambar Nota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="notaImage" src="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay di Tengah Layar -->
    <div id="overlay"></div>
    <!-- Spinner di Tengah Layar -->
    <div id="spinner" class="spinner-border text-success" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
@endsection

@section('script')
    <script src="/assets/compiled/js/jquery.min.js"></script>
    <script src="/assets/compiled/js/jquery.dataTables.min.js"></script>
    <script src="/assets/compiled/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#table_nasabah').DataTable();

            $('.deleteButton').on('click', function(e) {
                e.preventDefault();
                var purchaseId = $(this).data('id');
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Ingin Menghapus Transaksi Jual ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampilkan spinner dan overlay setelah konfirmasi penghapusan
                        document.getElementById('spinner').style.display = 'block';
                        document.getElementById('overlay').style.display = 'block';

                        // Submit form
                        $('#delete-form-' + purchaseId).submit();
                    }
                });
            });
        });

        // jQuery to show spinner and overlay when form is submitted
        $(document).ready(function() {
            $('form').on('submit', function() {
                // Tampilkan overlay dan spinner saat form disubmit
                document.getElementById('overlay').style.display = 'block';
                document.getElementById('spinner').style.display = 'block';
            });
        });


        function showNotaImage(imageUrl) {
            $('#notaImage').attr('src', imageUrl);
            $('#gambarNotaModal').modal('show');
        }

        // Fungsi AJAX untuk memperbarui status transaksi
        function fetchTransactionStatus() {
            $.ajax({
                url: "{{ route('transaksi_jual_nasabah') }}",
                method: 'GET',
                success: function(data) {
                    $('#sales-table-body').empty(); // Bersihkan isi tabel
                    data.forEach(function(sales, index) {
                        $('#sales-table-body').append(`
                            <tr id="sales-${sales.id}">
                                <td>${index + 1}</td>
                                <td>${sales.tanggal_jual}</td>
                                <td>${sales.jenis_sampah}</td>
                                <td><img src="{{ asset('storage/assets/sampah_penjualan') }}/${sales.gambar_sampah}" width="60px" height="60px"></td>
                                <td>${sales.berat}</td>
                                <td>${sales.harga}</td>
                                <td>${sales.total}</td>
                                <td style="text-align: center">
                                    <a href="#" class="btn btn-primary btn-sm" style="color: white" onclick="showNotaImage('{{ asset('storage/assets/tanda_tangan_jual') }}/${sales.gambar_ttd}')">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                </td>
                                <td style="text-align: center;">
                                    ${renderStatus(sales.status_konfirmasi)}
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{ route('edit_transaksi_jual_nasabah', ['id' => '']) }}${sales.id}" class="btn btn-warning btn-sm" style="color: white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-sm deleteButton" data-id="${sales.id}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <form id="delete-form-${sales.id}" action="{{ route('destroy_transaksi_jual_nasabah', '') }}${sales.id}" method="get" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        `);
                    });
                }
            });
        }

        // Fungsi untuk menampilkan status konfirmasi
        function renderStatus(status) {
            if (status == 'belum dikonfirmasi') {
                return `<span class="badge bg-danger">Belum Dikonfirmasi</span>`;
            } else if (status == 'sedang dijemput') {
                return `<span class="badge bg-warning">Sedang Dijemput</span>`;
            } else if (status == 'sampah telah diterima') {
                return `<span class="badge bg-info">Sampah Telah Diterima</span>`;
            } else if (status == 'sudah dikonfirmasi') {
                return `<span class="badge bg-success">Sudah Dikonfirmasi</span>`;
            }
        }

        // Jalankan fetchTransactionStatus setiap 5 detik
        setInterval(fetchTransactionStatus, 5000);
    </script>
@endsection
