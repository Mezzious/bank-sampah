@extends('layout.app')

@section('content')
    <div class="main">
        <div class="page-heading">
            <div class="row">
                <div class="d-flex align-items-center justify-content-between ">
                    <h2 style="font-size: 30px" class="h2 mb-0 col-4 col-md-2 text-gray-800">Laporan Beli Sampah</h2>
                    <div class="col-8 col-xl-10 col-lg-9 col-md-8 col-sm-9 d-flex align-items-center justify-content-end">
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
            <span style="color: white;">Back</span>
        </a>
    </div>

    <!-- Alert -->
    <div id="alertSuccess" class="alert alert-success mt-3" role="alert" style="display:none;">
        Tanggal awal: <span id="tglAwal"></span><br>
        Tanggal akhir: <span id="tglAkhir"></span>
    </div>


    <form action="#" method="post" name="form10" target="_self">
        <div class="row">
            <div class="col-lg-3">
                <input name="txtTglAwal" type="date" class="form-control" size="10" />
            </div>
            <div class="col-lg-3">
                <input name="txtTglAkhir" type="date" class="form-control" size="10" />
            </div>

            <div class="col-lg-3">
                <input name="btnTampil" style="color: white" class="btn btn-custom" type="submit" value="Tampilkan"
                    onclick="tampilkanTanggal()" />
            </div>
        </div>
    </form>

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
                                    <th>Id</th>
                                    <th>Tanggal_Beli</th>
                                    <th>Customer_Id</th>
                                    <th>Jenis_Sampah</th>
                                    <th>Gambar</th>
                                    <th>Berat</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>5454</td>
                                    <td>11/03/2024</td>
                                    <td>8989</td>
                                    <td>Kardus</td>
                                    <td><img src="https://down-id.img.susercontent.com/file/d41d0ab1c03c710ae114912cf4297f74"width="60px"
                                            height="60px"></td>
                                    <td>10Kg</td>
                                    <td>5000</td>
                                    <td>50000</td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="#" class="btn btn-custom" id="printButton">
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
            $('#table_laporan_beli').DataTable();
        });
    </script>

    <script>
        function tampilkanTanggal() {
            // Mendapatkan nilai tanggal awal dan tanggal akhir dari form
            var tglAwal = document.forms["form10"]["txtTglAwal"].value;
            var tglAkhir = document.forms["form10"]["txtTglAkhir"].value;

            // Redirect ke URL cetak laporan dengan parameter tanggal
            window.location.href = "cetak_laporan_beli.php?tglAwal=" + tglAwal + "&tglAkhir=" + tglAkhir;
        }
    </script>

    <script>
        function tampilkanTanggal() {
            // Mengambil nilai dari input date
            var tglAwal = document.getElementById("txtTglAwal").value;
            var tglAkhir = document.getElementById("txtTglAkhir").value;

            // Memecah tanggal menjadi tahun, bulan, dan tanggal
            var tglAwalArr = tglAwal.split('-');
            var tglAkhirArr = tglAkhir.split('-');

            // Format tanggal, bulan, dan tahun
            var tglAwalFormatted = tglAwalArr[2] + '-' + tglAwalArr[1] + '-' + tglAwalArr[0];
            var tglAkhirFormatted = tglAkhirArr[2] + '-' + tglAkhirArr[1] + '-' + tglAkhirArr[0];

            // Menampilkan alert
            document.getElementById("tglAwal").innerText = tglAwalFormatted;
            document.getElementById("tglAkhir").innerText = tglAkhirFormatted;
            document.getElementById("alertSuccess").style.display = "block";
        }
    </script>
@endsection
