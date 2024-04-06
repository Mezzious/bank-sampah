@extends('layout.app_admin')

@section('content')
    <div class="main">
        <div class="page-heading">
            <div class="row">
                <div class="d-flex align-items-center justify-content-between ">
                    <h2 style="font-size: 30px" class="h2 mb-0 col-4 col-md-2 text-gray-800">Data Nasabah</h2>
                    <div class="col-8 col-xl-10 col-lg-9 col-md-8 col-sm-9 d-flex align-items-center justify-content-end">
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
                                        href="{{ route('ganti_password_user') }}">
                                        <i class="bi bi-key-fill"></i> Password
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
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
                                <table id="table_nasabah" class="table table-bordered">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th>No</th>
                                            <th>Id_Nasabah</th>
                                            <th>Nama</th>
                                            <th>RW</th>
                                            <th>Telepon</th>
                                            <th>Alamat</th>
                                            <th>Sampah</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        <tr>
                                            <td>1</td>
                                            <td>212</td>
                                            <td>John Doe</td>
                                            <td>1</td>
                                            <td>123-456-7890</td>
                                            <td>Jl. Duri Kepa</td>
                                            <td>50Kg</td>
                                        </tr>
                                        <tr id="tableBody">
                                            <td>2</td>
                                            <td>132</td>
                                            <td>John Cena</td>
                                            <td>2</td>
                                            <td>123-555-7890</td>
                                            <td>Jl. Duri Kepa 2</td>
                                            <td>30Kg</td>
                                        </tr>
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
                    $('#table_nasabah').DataTable();
                });
            </script>
        @endsection
