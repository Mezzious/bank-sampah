@extends('layout.app')

@section('content')
    <h2 style="font-size: 30px;">Transaksi Beli Sampah</h2>
    <br>

    <link rel="stylesheet" href="./assets/compiled/css/all.view.css">
    <link rel="stylesheet" href="./assets/compiled/css/dataTables.bootstrap4.min.css">

    <div class="back-button-container" style="margin-bottom: 10px">
        <a class="btn back-button" onclick="goBack()">
            <i class="fa-solid fa-arrow-left" style="color: white;"></i>
            <span style="color: white;">Back</span>
        </a>
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
                        <table id="table_beli" class="table table-bordered">
                            <thead class="table-secondary">
                                <tr>
                                    <th>No</th>
                                    <th>Id Beli</th>
                                    <th>Tanggal Beli</th>
                                    <th>Jenis Sampah</th>
                                    <th>Id Nasabah</th>
                                    <th>Berat</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                    <th>Id User</th>
                                    <th>Nota</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>5454</td>
                                    <td>11/03/2024</td>
                                    <td>Kardus</td>
                                    <td>555</td>
                                    <td>5Kg</td>
                                    <td>5000</td>
                                    <td>25000</td>
                                    <td>123</td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm"
                                            style="color: white"> <i class="bi bi-eye-fill"></i> </a>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('edit_transaksi_beli') }}" class="btn btn-warning btn-sm"
                                            style="color: white"> <i class="fas fa-edit"></i> </a>
                                        <a type="submit" class="btn btn-danger btn-sm" onclick="return confirmDelete()"><i
                                                class="fas fa-trash"></i> </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>5353</td>
                                    <td>11/03/2024</td>
                                    <td>Botol</td>
                                    <td>555</td>
                                    <td>5Kg</td>
                                    <td>3000</td>
                                    <td>15000</td>
                                    <td>123</td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm"
                                            style="color: white"> <i class="bi bi-eye-fill"></i> </a>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('edit_transaksi_beli') }}" class="btn btn-warning btn-sm"
                                            style="color: white"> <i class="fas fa-edit"></i> </a>
                                        <a type="submit" class="btn btn-danger btn-sm" onclick="return confirmDelete()"><i
                                                class="fas fa-trash"></i> </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tambah_transaksi_beli') }}" class="btn btn-custom">
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
                $('#table_beli').DataTable();
            });
        </script>
    @endsection
