@extends('layout.app_user')

@section('content')
    <div class="main">
        <div class="page-heading">
            <div class="row">
                <div class="d-flex align-items-center justify-content-between ">
                    <h2 class="h2 mb-0 col-4 col-md-2 text-gray-800">Transaksi Beli Sampah</h2>
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
                                            href="{{ route('ganti_password_user') }}">
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
                            <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
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
                <a class="btn btn-block btn-custom mb-2" style="border-radius: 8px;" href="{{ route('ganti_password_admin') }}">
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

    <div class="back-button-container" style="margin-bottom: 10px;">
        <a class="btn back-button" onclick="goBack()">
            <i class="fa-solid fa-arrow-left" style="color: white;"></i>
            <span style="color: white;">Back</span>
        </a>
    </div>

    <form action="{{ route('tampilkan_tanggal_transaksi_user') }}" method="post" name="form10">
        @csrf
        <div class="row">
            <div class="col-lg-3">
                <input name="txtTglAwal" id="txtTglAwal" type="date" class="form-control" size="10" required />
            </div>
            <div class="col-lg-3">
                <input name="txtTglAkhir" id="txtTglAkhir" type="date" class="form-control" size="10" required />
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
                            <table id="table_jual" class="table table-bordered">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>No</th>
                                        {{-- <th>Id</th>
                                <th>User_Id</th> --}}
                                        <th>Tanggal Beli</th>
                                        <th>Jenis Sampah</th>
                                        <th>Gambar Sampah</th>
                                        <th>Berat (Kg)</th>
                                        <th>Harga (Rp)</th>
                                        <th>Total (Rp)</th>
                                        <th>Nota</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($saleses as $sales)
                                        <tr>
                                            <td> {{ $loop->iteration }} </td>
                                            {{-- <td> {{ $sales->id }} </td>
                                {{-- <td> {{ $sales->user_id }} </td> --}}
                                            <td> {{ $sales->tanggal_jual }} </td>
                                            <td> {{ $sales->jenis_sampah }} </td>
                                            <td><img src="{{ asset('storage/assets/sampah_penjualan/' . $sales->gambar_sampah) }}"width="60px"
                                                    height="60px"></td>
                                            <td> {{ $sales->berat }} </td>
                                            <td> {{ $sales->harga }} </td>
                                            <td> {{ $sales->total }} </td>
                                            <td style="text-align: center">
                                                <a href="#" class="btn btn-primary btn-sm" style="color: white"
                                                    onclick="showNotaImage('{{ asset('storage/assets/nota_jual/' . $sales->gambar_nota) }}')">
                                                    <i class="bi bi-eye-fill"></i> </a>
                                            </td>
                                            <td style="text-align: center;">
                                                <a href="{{ route('edit_transaksi_beli_user', ['id' => $sales->id]) }}"
                                                    class="btn btn-warning btn-sm" style="color: white"> <i
                                                        class="fas fa-edit"></i> </a>
                                                <a href="#" class="btn btn-danger btn-sm deleteButton"
                                                    data-id="{{ $sales->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <form id="delete-form-{{ $sales->id }}"
                                                    action="{{ route('destroy_transaksi_beli_user', $sales->id) }}"
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
                                <a href="{{ route('tambah_transaksi_beli_user') }}" class="btn btn-custom">
                                    <i class="fa-solid fa-cart-plus" style="color: white; margin-right: 5px;"></i>
                                    <span style="color: white;">Tambah</span>
                                </a>
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
@endsection

@section('script')
    <script src="/assets/compiled/js/jquery.min.js"></script>
    <script src="/assets/compiled/js/jquery.dataTables.min.js"></script>
    <script src="/assets/compiled/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#table_jual').DataTable();

            $('.deleteButton').on('click', function(e) {
                e.preventDefault();
                var salesId = $(this).data('id');
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Ingin Menghapus Transaksi beli ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete-form-' + salesId).submit();
                    }
                })
            });
        });

        function showNotaImage(imageUrl) {
            $('#notaImage').attr('src', imageUrl);
            $('#gambarNotaModal').modal('show');
        }
    </script>
@endsection
