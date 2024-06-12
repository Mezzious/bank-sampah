@extends('layout.app')

@section('content')
    <div class="main">
        <div class="page-heading">
            <div class="row">
                <div class="d-flex align-items-center justify-content-space-between">
                    <h2 class="h2 mb-0 col-4 col-md-2 text-gray-800">Laporan Jual Sampah</h2>
                    <div class="col-8 col-xl-10 col-lg-9 col-md-8 col-sm-9 d-flex align-items-center justify-content-end">
                        <div class="dropdown">
                            <a href="#" id="topbarUserDropdown"
                                class="user-dropdown d-flex align-items-center dropend dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="text">
                                    <h6 class="user-dropdown-name">Selamat Datang, {{ auth()->user()->name }}</h6>
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
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="./assets/compiled/css/all.view.css">
    <link rel="stylesheet" href="./assets/compiled/css/dataTables.bootstrap4.min.css">

    <div class="back-button-container" style="margin-bottom: 10px">
        <a class="btn back-button" onclick="goBack()">
            <i class="fa-solid fa-arrow-left" style="color: white;"></i>
            <span style="color: white;">Kembali</span>
        </a>
    </div>

    <form action="" method="get" name="form10" target="_self">
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
                                    <th>Tanggal Jual</th>
                                    <th>Jenis Sampah</th>
                                    <th>Gambar</th>
                                    <th>Berat (Kg)</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $grandTotal = 0; @endphp
                                @foreach ($saleses as $sales)
                                    @php $grandTotal += $sales->total; @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $sales->tanggal_jual }}</td>
                                        <td>{{ $sales->jenis_sampah }}</td>
                                        <td><img src="{{ asset('storage/assets/sampah_penjualan/'.$sales->gambar_sampah) }}" width="60px" height="60px"></td>
                                        <td>{{ $sales->berat }}</td>
                                        <td>{{ $sales->harga }}</td>
                                        <td>{{ $sales->total }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6" class="text-right font-weight-bold">Jumlah Total</td>
                                    <td class="font-weight-bold">{{ $grandTotal }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div>
                            <a href="#" class="btn btn-custom" id="printButton" onclick="window.print()">
                                <i class="fa-solid fa-print" style="color: white;"></i> <span style="color: white;">Cetak</span>
                            </a>
                        </div>
                    </div>
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
            $('#table_laporan_jual').DataTable();
        });

        function tampilkanTanggal() {
            var tglAwal = document.getElementById("txtTglAwal").value;
            var tglAkhir = document.getElementById("txtTglAkhir").value;

            if (!tglAwal || !tglAkhir) {
                alert("Silakan isi kedua tanggal.");
                return;
            }

            var tglAwalArr = tglAwal.split('-');
            var tglAkhirArr = tglAkhir.split('-');

            var tglAwalFormatted = tglAwalArr[2] + '-' + tglAwalArr[1] + '-' + tglAwalArr[0];
            var tglAkhirFormatted = tglAkhirArr[2] + '-' + tglAkhirArr[1] + '-' + tglAkhirArr[0];

            document.getElementById("tglAwal").innerText = tglAwalFormatted;
            document.getElementById("tglAkhir").innerText = tglAkhirFormatted;
            document.getElementById("alertSuccess").style.display = "block";
        }
    </script>
@endsection
