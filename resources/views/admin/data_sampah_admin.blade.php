@extends('layout.app_admin')

@section('content')
<div class="main">
    <div class="page-heading">
        <div class="row">
            <div class="d-flex align-items-center justify-content-between ">
                <h2 class="h2 mb-0 col-4 col-md-2 text-gray-800">Data Sampah</h2>
                <div class="d-flex align-items-center">
                    <!-- Menu for larger screens -->
                    <div class="d-none d-md-flex align-items-center">
                        <div class="dropdown">
                            <a href="#" id="topbarUserDropdown"
                                class="user-dropdown d-flex align-items-center dropend dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="text">
                                    <h6 class="user-dropdown-name">Selamat Datang, {{ ucfirst(auth()->user()->roles) }}</h6>
                                    <p class="user-dropdown-status text-sm text-muted"></p>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-center shadow-lg text-center p-3"
                                aria-labelledby="topbarUserDropdown" style="border-radius: 10px;">
                                <li>
                                    <a class="btn btn-block btn-custom mb-2" style="border-radius: 8px;"
                                        href="{{ route('ganti_password_admin') }}">
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
        <h5 class="offcanvas-title" id="offcanvasMenuLabel">Selamat Datang, {{ ucfirst(auth()->user()->roles) }}</h5>
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

    <div class="back-button-container" style="margin-bottom: 5px; margin-left: 1px;">
        <a class="btn back-button" onclick="goBack()">
            <i class="fa-solid fa-arrow-left" style="color: white;"></i>
            <span style="color: white;">Back</span>
        </a>
    </div>

    <div class="mb-3"></div>
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_sampah" class="table table-bordered">
                            <thead class="table-secondary">
                                <tr>
                                    <th>No</th>
                                    {{-- <th>Id</th>
                                    <th>User_Id</th> --}}
                                    <th>Jenis_Sampah</th>
                                    <th>Satuan</th>
                                    <th>Harga per Kg (Rp)</th>
                                    <th>Gambar</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($trashes as $trash)
                                    
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    {{-- <td>212</td>
                                    <td>252</td> --}}
                                    <td> {{ $trash->jenis_sampah }} </td>
                                    <td> {{ $trash->satuan }} </td>
                                    <td> {{ $trash->harga }} </td>
                                    <td><img src="{{ asset('storage/assets/sampah/'.$trash->gambar) }}"width="60px"
                                        height="60px"></td>
                                    <td> {{ $trash->deskripsi }} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
            $('#table_sampah').DataTable();
        });
    </script>
@endsection
