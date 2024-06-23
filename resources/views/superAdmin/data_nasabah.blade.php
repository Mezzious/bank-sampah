@extends('layout.app')

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

    <div class="back-button-container" style="margin-bottom: 5px; margin-left: 1px;">
        <a class="btn back-button" onclick="goBack()">
            <i class="fa-solid fa-arrow-left" style="color: white;"></i>
            <span style="color: white;">Back</span>
        </a>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
        </div>
    @endif

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
                                    <th>Id</th>
                                    {{-- <th>User_Id</th> --}}
                                    <th>Nama</th>
                                    <th>Email</th>
                                    {{-- <th>Password</th> --}}
                                    <th>RW</th>
                                    <th>Telepon</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($cust as $customer)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $customer->id }} </td>
                                    {{-- <td> {{ $customer->user_id }} </td> --}}
                                    <td> {{ $customer->user->name }} </td>
                                    <td> {{ $customer->user->email }} </td>
                                    {{-- <td> {{ $customer->user->password }} </td> --}}
                                    <td> {{ $customer->rw }} </td>
                                    <td> {{ $customer->telepon }} </td>
                                    <td> {{ $customer->alamat }} </td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('edit_nasabah', ['id' => $customer->id]) }}" class="btn btn-warning btn-sm"
                                        style="color: white"> <i class="fas fa-edit"></i> </a>
                                        <a href="{{ route('destroy_nasabah', $customer->user_id) }}" type="submit" class="btn btn-danger btn-sm" onclick="return confirmDelete()"><i
                                            class="fas fa-trash"></i> </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tambah_nasabah') }}" class="btn btn-custom">
                                <i class="fa-solid fa-user-plus" style="color: white; margin-right: 5px;"></i>
                                <span style="color: white;">Tambah</span>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#table_nasabah').DataTable();
        });
    </script>
@endsection
