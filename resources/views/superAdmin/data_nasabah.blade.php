@extends('layout.app')

@section('content')
    <link rel="stylesheet" href="./assets/compiled/css/all.view.css">
    <link rel="stylesheet" href="./assets/compiled/css/dataTables.bootstrap4.min.css">

    <h2 style="font-size: 30px;">Data Nasabah</h2>
    <br>

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
                                            <th>Aksi</th>
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
                                            <td style="text-align: center;">
                                                <a href="{{ route('edit_user') }}" class="btn btn-warning btn-sm"
                                                    style="color: white"> <i class="fas fa-edit"></i> </a>
                                                <a type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirmDelete()"><i class="fas fa-trash"></i> </a>
                                            </td>
                                        </tr>
                                        <tr id="tableBody">
                                            <td>2</td>
                                            <td>132</td>
                                            <td>John Cena</td>
                                            <td>2</td>
                                            <td>123-555-7890</td>
                                            <td>Jl. Duri Kepa 2</td>
                                            <td>30Kg</td>
                                            <td style="text-align: center;">
                                                <a href="{{ route('edit_user') }}" class="btn btn-warning btn-sm"
                                                    style="color: white"> <i class="fas fa-edit"></i> </a>
                                                <a type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirmDelete()"><i class="fas fa-trash"></i> </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('tambah_user') }}" class="btn btn-custom">
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

            <script>
                $(document).ready(function() {
                    $('#table_nasabah').DataTable();
                });
            </script>
        @endsection
