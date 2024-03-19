@extends('layout.app')

@section('content')
    <h2 style="font-size: 30px;">Data User</h2>
    <br>
{{-- CSSKU --}}
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
                        <table id="table_user" class="table table-bordered">
                            <thead class="table-secondary">
                                <tr>
                                    <th>No</th>
                                    <th>Id_User</th>
                                    <th>Nama User</th>
                                    <th>Nomor Telepon</th>
                                    <th>E-mail</th>
                                    <th>Level</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <tr>
                                    <td>1</td>
                                    <td>212</td>
                                    <td>John Doe</td>
                                    <td>123-456-7890</td>
                                    <td>john.doe@example.com</td>
                                    <td>Admin</td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('edit_user') }}" class="btn btn-warning btn-sm"
                                            style="color: white"> <i class="fas fa-edit"></i> </a>
                                        <a type="submit" class="btn btn-danger btn-sm" onclick="return confirmDelete()"><i
                                                class="fas fa-trash"></i> </a>
                                        <a href="{{ route('ganti_password') }}" class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-key"></i></a>
                                    </td>
                                </tr>
                                <tr id="tableBody">
                                    <td>2</td>
                                    <td>124</td>
                                    <td>John Goe</td>
                                    <td>123-456-7899</td>
                                    <td>john.goe@example.com</td>
                                    <td>User</td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('edit_user') }}" class="btn btn-warning btn-sm"
                                            style="color: white"> <i class="fas fa-edit"></i> </a>
                                        <a type="submit" class="btn btn-danger btn-sm" onclick="return confirmDelete()"><i
                                                class="fas fa-trash"></i> </a>
                                        <a href="{{ route('ganti_password') }}" class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-key"></i></a>
                                    </td>
                                </tr>
                                <tr id="tableBody">
                                    <td>2</td>
                                    <td>124</td>
                                    <td>John Goe</td>
                                    <td>123-456-7899</td>
                                    <td>john.goe@example.com</td>
                                    <td>User</td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('edit_user') }}" class="btn btn-warning btn-sm"
                                            style="color: white"> <i class="fas fa-edit"></i> </a>
                                        <a type="submit" class="btn btn-danger btn-sm" onclick="return confirmDelete()"><i
                                                class="fas fa-trash"></i> </a>
                                        <a href="{{ route('ganti_password') }}" class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-key"></i></a>
                                    </td>
                                </tr>
                                <tr id="tableBody">
                                    <td>2</td>
                                    <td>124</td>
                                    <td>John Goe</td>
                                    <td>123-456-7899</td>
                                    <td>john.goe@example.com</td>
                                    <td>User</td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('edit_user') }}" class="btn btn-warning btn-sm"
                                            style="color: white"> <i class="fas fa-edit"></i> </a>
                                        <a type="submit" class="btn btn-danger btn-sm" onclick="return confirmDelete()"><i
                                                class="fas fa-trash"></i> </a>
                                        <a href="{{ route('ganti_password') }}" class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-key"></i></a>
                                    </td>
                                </tr>
                                <tr id="tableBody">
                                    <td>2</td>
                                    <td>124</td>
                                    <td>John Goe</td>
                                    <td>123-456-7899</td>
                                    <td>john.goe@example.com</td>
                                    <td>User</td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('edit_user') }}" class="btn btn-warning btn-sm"
                                            style="color: white"> <i class="fas fa-edit"></i> </a>
                                        <a type="submit" class="btn btn-danger btn-sm" onclick="return confirmDelete()"><i
                                                class="fas fa-trash"></i> </a>
                                        <a href="{{ route('ganti_password') }}" class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-key"></i></a>
                                    </td>
                                </tr>
                                <tr id="tableBody">
                                    <td>2</td>
                                    <td>124</td>
                                    <td>John Goe</td>
                                    <td>123-456-7899</td>
                                    <td>john.goe@example.com</td>
                                    <td>User</td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('edit_user') }}" class="btn btn-warning btn-sm"
                                            style="color: white"> <i class="fas fa-edit"></i> </a>
                                        <a type="submit" class="btn btn-danger btn-sm" onclick="return confirmDelete()"><i
                                                class="fas fa-trash"></i> </a>
                                        <a href="{{ route('ganti_password') }}" class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-key"></i></a>
                                    </td>
                                </tr>
                                <tr id="tableBody">
                                    <td>2</td>
                                    <td>124</td>
                                    <td>John Goe</td>
                                    <td>123-456-7899</td>
                                    <td>john.goe@example.com</td>
                                    <td>User</td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('edit_user') }}" class="btn btn-warning btn-sm"
                                            style="color: white"> <i class="fas fa-edit"></i> </a>
                                        <a type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirmDelete()"><i class="fas fa-trash"></i> </a>
                                        <a href="{{ route('ganti_password') }}" class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-key"></i></a>
                                    </td>
                                </tr>
                                <tr id="tableBody">
                                    <td>2</td>
                                    <td>124</td>
                                    <td>John Goe</td>
                                    <td>123-456-7899</td>
                                    <td>john.goe@example.com</td>
                                    <td>User</td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('edit_user') }}" class="btn btn-warning btn-sm"
                                            style="color: white"> <i class="fas fa-edit"></i> </a>
                                        <a type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirmDelete()"><i class="fas fa-trash"></i> </a>
                                        <a href="{{ route('ganti_password') }}" class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-key"></i></a>
                                    </td>
                                </tr>
                                <tr id="tableBody">
                                    <td>2</td>
                                    <td>124</td>
                                    <td>John Goe</td>
                                    <td>123-456-7899</td>
                                    <td>john.goe@example.com</td>
                                    <td>User</td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('edit_user') }}" class="btn btn-warning btn-sm"
                                            style="color: white"> <i class="fas fa-edit"></i> </a>
                                        <a type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirmDelete()"><i class="fas fa-trash"></i> </a>
                                        <a href="{{ route('ganti_password') }}" class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-key"></i></a>
                                    </td>
                                </tr>
                                <tr id="tableBody">
                                    <td>2</td>
                                    <td>124</td>
                                    <td>John Goe</td>
                                    <td>123-456-7899</td>
                                    <td>john.goe@example.com</td>
                                    <td>User</td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('edit_user') }}" class="btn btn-warning btn-sm"
                                            style="color: white"> <i class="fas fa-edit"></i> </a>
                                        <a type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirmDelete()"><i class="fas fa-trash"></i> </a>
                                        <a href="{{ route('ganti_password') }}" class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-key"></i></a>
                                    </td>
                                </tr>
                                <tr id="tableBody">
                                    <td>2</td>
                                    <td>124</td>
                                    <td>John Goe</td>
                                    <td>123-456-7899</td>
                                    <td>john.goe@example.com</td>
                                    <td>User</td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('edit_user') }}" class="btn btn-warning btn-sm"
                                            style="color: white"> <i class="fas fa-edit"></i> </a>
                                        <a type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirmDelete()"><i class="fas fa-trash"></i> </a>
                                        <a href="{{ route('ganti_password') }}" class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-key"></i></a>
                                    </td>
                                </tr>
                                <tr id="tableBody">
                                    <td>2</td>
                                    <td>124</td>
                                    <td>John Goe</td>
                                    <td>123-456-7899</td>
                                    <td>john.goe@example.com</td>
                                    <td>User</td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('edit_user') }}" class="btn btn-warning btn-sm"
                                            style="color: white"> <i class="fas fa-edit"></i> </a>
                                        <a type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirmDelete()"><i class="fas fa-trash"></i> </a>
                                        <a href="{{ route('ganti_password') }}" class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-key"></i></a>
                                    </td>
                                </tr>
                                <tr id="tableBody">
                                    <td>2</td>
                                    <td>124</td>
                                    <td>John Goe</td>
                                    <td>123-456-7899</td>
                                    <td>john.goe@example.com</td>
                                    <td>User</td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('edit_user') }}" class="btn btn-warning btn-sm"
                                            style="color: white"> <i class="fas fa-edit"></i> </a>
                                        <a type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirmDelete()"><i class="fas fa-trash"></i> </a>
                                        <a href="{{ route('ganti_password') }}" class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-key"></i></a>
                                    </td>
                                </tr>
                                <tr id="tableBody">
                                    <td>2</td>
                                    <td>124</td>
                                    <td>John Goe</td>
                                    <td>123-456-7899</td>
                                    <td>john.goe@example.com</td>
                                    <td>User</td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('edit_user') }}" class="btn btn-warning btn-sm"
                                            style="color: white"> <i class="fas fa-edit"></i> </a>
                                        <a type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirmDelete()"><i class="fas fa-trash"></i> </a>
                                        <a href="{{ route('ganti_password') }}" class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-key"></i></a>
                                    </td>
                                </tr>
                                <tr id="tableBody">
                                    <td>2</td>
                                    <td>124</td>
                                    <td>John Goe</td>
                                    <td>123-456-7899</td>
                                    <td>john.goe@example.com</td>
                                    <td>User</td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('edit_user') }}" class="btn btn-warning btn-sm"
                                            style="color: white"> <i class="fas fa-edit"></i> </a>
                                        <a type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirmDelete()"><i class="fas fa-trash"></i> </a>
                                        <a href="{{ route('ganti_password') }}" class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-key"></i></a>
                                    </td>
                                </tr>
                                <tr id="tableBody">
                                    <td>2</td>
                                    <td>124</td>
                                    <td>John Goe</td>
                                    <td>123-456-7899</td>
                                    <td>john.goe@example.com</td>
                                    <td>User</td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('edit_user') }}" class="btn btn-warning btn-sm"
                                            style="color: white"> <i class="fas fa-edit"></i> </a>
                                        <a type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirmDelete()"><i class="fas fa-trash"></i> </a>
                                        <a href="{{ route('ganti_password') }}" class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-key"></i></a>
                                    </td>
                                </tr>
                                <tr id="tableBody">
                                    <td>2</td>
                                    <td>124</td>
                                    <td>John Goe</td>
                                    <td>123-456-7899</td>
                                    <td>john.goe@example.com</td>
                                    <td>User</td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('edit_user') }}" class="btn btn-warning btn-sm"
                                            style="color: white"> <i class="fas fa-edit"></i> </a>
                                        <a type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirmDelete()"><i class="fas fa-trash"></i> </a>
                                        <a href="{{ route('ganti_password') }}" class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-key"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
@endsection

@section('script')
    <script src="/assets/compiled/js/jquery.min.js"></script>
    <script src="/assets/compiled/js/jquery.dataTables.min.js"></script>
    <script src="/assets/compiled/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#table_user').DataTable();
        });
    </script>
@endsection
