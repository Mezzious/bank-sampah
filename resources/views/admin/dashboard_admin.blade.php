@extends('layout.app_admin')

@section('content')
    <!-- Begin Page Content -->
    <section class="section">

        <link rel="stylesheet" href="./assets/compiled/css/all.view.css">

        <!-- Page Heading -->
        <div class="main">
            <div class="page-heading">
                <div class="row">
                    <div class="d-flex align-items-center justify-content-between ">
                        <h2 style="font-size: 30px" class="h2 mb-0 col-4 col-md-2 text-gray-800">Dashboard</h2>
                        <div
                            class="col-8 col-xl-10 col-lg-9 col-md-8 col-sm-9 d-flex align-items-center justify-content-end">
                            <div class="dropdown">
                                <a href="#" id="topbarUserDropdown"
                                    class="user-dropdown d-flex align-items-center dropend dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="text">
                                        <h6 class="user-dropdown-name">ADMIN212</h6>
                                        <p class="user-dropdown-status text-sm text-muted"></p>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-center shadow-lg text-center p-3"
                                    aria-labelledby="topbarUserDropdown" style="border-radius: 10px;">
                                    <li>
                                        <a class="btn btn-block btn-custom mb-2" style="border-radius: 8px;"
                                            href="{{ route('ganti_password_admin') }}">
                                            <i class="bi bi-key-fill"></i> Ganti Password
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
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body d-grid" style="width: 100%">
                        <div class="row d-flex justify-content-between align-items-center">
                            <div class="col-auto">
                                <div class="h4 mb-0 font-bold text-gray-800">500</div>
                                <div class="text-xs font-bold text-primary text-uppercase mb-1">
                                    Total Sampah</div>
                            </div>

                            <div class="col-auto">
                                <i class="fa-regular fa-trash-can"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body d-flex align-items-center align-center">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h4 mb-0 font-bold text-gray-800">500</div>
                                <div class="text-xs font-bold text-success text-uppercase mb-1">
                                    Total Penjualan Sampah(Month)</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body d-flex align-items-center align-center">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h4 mb-0 font-bold text-gray-800">500</div>
                                <div class="text-xs font-bold text-success text-uppercase mb-1">
                                    Total Pembelian Sampah(Month)</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body d-grid">
                        <div class="row d-flex justify-content-between align-items-center">
                            <div class="col mr-2">
                                <div class="h4 mb-0 font-bold text-gray-800">18</div>
                                <div class="text-xs font-bold text-warning text-uppercase mb-1">
                                    Total User</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Content Row -->
        <div class="row">

            <div class="col-xl-12 col-lg-7">

                <!-- Area Chart -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Area Chart</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myAreaChart"></canvas>
                        </div>
                        <hr>
                        Grafik Monitoring Untung Rugi per Bulan
                    </div>
                </div>

                <!-- Bar Chart -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Bar Chart</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-bar">
                            <canvas id="myBarChart"></canvas>
                        </div>
                        <hr>
                        Grafik Monitoring Untung Rugi per Bulan
                    </div>
                </div>

            </div>

            </body>

            </html>
        @endsection
