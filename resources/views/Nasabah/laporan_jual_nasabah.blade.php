@extends('layout.app_nasabah')

@section('content')
    <div class="main">
        <div class="page-heading">
            <div class="row">
                <div class="d-flex align-items-center justify-content-between">
                    <h2 class="h2 mb-0 col-4 col-md-2 text-gray-800">Laporan Jual Sampah</h2>
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
                                            href="{{ route('ganti_password') }}">
                                            <i class="bi bi-key-fill"></i> Password
                                        </a>
                                    </li>
                                    <li>
                                        <form method="get" action="{{ route('logout') }}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
                {{-- <p class="user-dropdown-name">Selamat Datang, {{ $user->name }}</p> --}}
                <a class="btn btn-block btn-custom mb-2" style="border-radius: 8px;" href="{{ route('ganti_password') }}">
                    <i class="bi bi-key-fill"></i> Ganti Password
                </a>
                <form method="get" action="{{ route('logout') }}">
                    <input type="hidden" name="_token" value="Fp6EQq2SXZNoCNVF3DWv21fbnsh5DCjvA7Bgx5UK">
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
            <span style="color: white;">Kembali</span>
        </a>
    </div>

    <form action="{{ route('tampilkan_tanggal_laporan_jual_nasabah') }}" method="post" name="form10">
        @csrf
        <div class="row">
            <div class="col-lg-3">
                <input id="txtTglAwal" name="txtTglAwal" type="date" class="form-control" size="10" required />
            </div>
            <div class="col-lg-3">
                <input id="txtTglAkhir" name="txtTglAkhir" type="date" class="form-control" size="10" required />
            </div>
            <div class="col-lg-3">
                <input name="btnTampil" style="color: white" class="btn btn-custom" type="submit" value="Tampilkan" />
            </div>
        </div>
    </form>

    @if(isset($purchases))
    <div class="mb-3"></div>
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_laporan_beli" class="table table-bordered">
                            <thead class="table-secondary">
                                <tr>
                                    <th>No</th>
                                    <th>RW</th>
                                    <th>Tanggal Jual</th>
                                    <th>Jenis Sampah</th>
                                    <th>Gambar</th>
                                    <th>Berat (Kg)</th>
                                    <th>Harga (Rp)</th>
                                    <th>Total (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $grandTotal = 0; @endphp
                                @foreach ($purchases as $purchase)
                                    @php $grandTotal += $purchase->total; @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>0{{ $purchase->user->customer->rw }}</td>
                                        <td>{{ $purchase->tanggal_beli }}</td>
                                        <td>{{ $purchase->jenis_sampah }}</td>
                                        <td><img src="{{ asset('storage/assets/sampah_pembelian/'.$purchase->gambar_sampah) }}" width="60px" height="60px"></td>
                                        <td>{{ $purchase->berat }}</td>
                                        <td>{{ $purchase->harga }}</td>
                                        <td>{{ $purchase->total }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="7" class="text-right font-weight-bold">Jumlah Total</td>
                                    <td colspan="2" class="font-weight-bold">{{ $grandTotal }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div>
                            <a href="{{ route('cetak_laporan_jual_nasabah') }}" target="_blank" class="btn btn-custom" id="printButton">
                                <i class="fa-solid fa-print" style="color: white;"></i> <span style="color: white;">Cetak</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="modal fade" id="gambarNotaModal" tabindex="-1" aria-labelledby="gambarNotaModalLabel" aria-hidden="true">
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

    <script>
        $(document).ready(function() {
            $('#table_laporan_beli').DataTable();
        });

        function showNotaImage(imageUrl) {
            $('#notaImage').attr('src', imageUrl);
            $('#gambarNotaModal').modal('show');
        }
    </script>
@endsection
