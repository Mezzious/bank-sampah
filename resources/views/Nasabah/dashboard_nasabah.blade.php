@extends('layout.app_nasabah')

@section('content')
    <!-- Begin Page Content -->
    <section class="section">
        <!-- My Css -->
        <link rel="stylesheet" href="./assets/compiled/css/all.view.css">
        <!-- Page Heading -->
        <div class="main">
            <div class="page-heading">
                <div class="row">
                    <div class="d-flex align-items-center justify-content-between ">
                        <h2 class="h2 mb-0 col-4 col-md-2 text-gray-800">Dashboard</h2>
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
                <h5 class="offcanvas-title" id="offcanvasMenuLabel">Selamat Datang, RW 0{{ $customer->rw }}</h5>
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

        <div class="row">
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body d-grid" style="width: 100%">
                        <div class="row d-flex justify-content-between align-items-center">
                            <div class="col-auto">
                                <div class="h4 mb-0 font-bold text-gray-800">{{ $totalSampah }} Kg</div>
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

            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body d-flex align-items-center align-center">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h4 mb-0 font-bold text-gray-800">Rp {{ $totalPenjualanSampah }}</div>
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
        </div>

        <!-- Bar Chart for Sampah per Jenis -->
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="m-0 font-weight-bold text-primary">Sampah per Jenis (Kg)</h5>
                        <canvas id="sampahJenisChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data Sampah per Jenis
    const jenisSampah = @json($jenisSampah); // array jenis sampah
    const beratSampah = @json($beratSampah); // array berat per jenis

    // Setup Chart.js
    const ctx = document.getElementById('sampahJenisChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: jenisSampah, // Nama jenis sampah
            datasets: [{
                label: 'Jumlah Sampah (Kg)',
                data: beratSampah, // Berat per jenis sampah
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection