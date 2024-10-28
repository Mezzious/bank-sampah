@extends('layout.app')

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/5Bl1xZoDvj3FVBIpT9SNq9u/KfAZ5qON6lC7G" crossorigin="anonymous">
    <div class="back-button-container" style="margin-bottom: 10px;">
        <a class="btn back-button" onclick="goBack()">
            <i class="fa-solid fa-arrow-left" style="color: white;"></i>
            <span style="color: white;">Kembali</span>
        </a>
    </div>

    <form action="{{ route('tampilkan_tanggal_jual_laporan') }}" method="post" name="form10">
        @csrf
        <div class="row">
            <div class="col-lg-3">
                <input id="txtTglAwal" name="txtTglAwal" type="date" class="form-control" size="10" />
            </div>
            <div class="col-lg-3">
                <input id="txtTglAkhir" name="txtTglAkhir" type="date" class="form-control" size="10" />
            </div>
            <div class="col-lg-3">
                <input name="btnTampil" style="color: white" class="btn btn-custom" type="submit" value="Tampilkan" />
            </div>
        </div>
    </form>

    @if (isset($saleses))
        <div class="mb-3"></div>
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table_laporan_jual" class="table table-bordered">
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
                                    @foreach ($saleses as $sales)
                                        @php $grandTotal += $sales->total; @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>0{{ $sales->user->customer->rw }}</td>
                                            <td>{{ $sales->tanggal_jual }}</td>
                                            <td>{{ $sales->jenis_sampah }}</td>
                                            <td><img src="{{ asset('storage/assets/sampah_penjualan/' . $sales->gambar_sampah) }}"
                                                    width="60px" height="60px"></td>
                                            <td>{{ $sales->berat }}</td>
                                            <td>{{ $sales->harga }}</td>
                                            <td>{{ $sales->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tr>
                                    <td colspan="7" class="text-right font-weight-bold">Jumlah Total</td>
                                    <td colspan="2" class="font-weight-bold">{{ $grandTotal }}</td>
                                </tr>
                            </table>
                            <div>
                                <a href="{{ route('cetak_laporan_jual') }}" target="_blank" class="btn btn-custom"
                                    id="printButton">
                                    <i class="fa-solid fa-print" style="color: white;"></i> <span
                                        style="color: white;">Cetak</span>
                                </a>
                                <button id="exportButton" class="btn btn-custom">
                                    <i class="fa-solid fa-file-export" style="color: white;"></i> <span style="color: white;">Export</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#table_laporan_jual').DataTable();
        });

        function showNotaImage(imageUrl) {
            $('#notaImage').attr('src', imageUrl);
            $('#gambarNotaModal').modal('show');
        }

        document.getElementById('dateReportForm').addEventListener('submit', function() {
            // Show overlay and spinner
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('spinner').style.display = 'block';
        });
    </script>

    <script>
        document.getElementById('exportButton').addEventListener('click', function() {
            // Ambil tabel laporan beli
            var table = document.getElementById('table_laporan_jual');
            var data = [];
            
            // Ambil header tabel (thead)
            var headers = [];
            table.querySelectorAll('thead th').forEach(function(th, index) {
                // Skip kolom gambar
                if (index !== 4) {  // Kolom gambar ada di indeks 3
                    headers.push(th.innerText);
                }
            });
            data.push(headers);

            // Ambil isi tabel (tbody)
            table.querySelectorAll('tbody tr').forEach(function(row) {
                var rowData = [];
                row.querySelectorAll('td').forEach(function(td, index) {
                    // Skip kolom gambar
                    if (index !== 4) {  // Kolom gambar ada di indeks 3
                        rowData.push(td.innerText);
                    }
                });
                data.push(rowData);
            });

            // Membuat workbook Excel dengan SheetJS
            var worksheet = XLSX.utils.aoa_to_sheet(data);
            var workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Laporan Jual Sampah");

            // Ekspor dan unduh file Excel
            XLSX.writeFile(workbook, 'Laporan_Jual_Sampah.xlsx');
        });
    </script>

@endsection
