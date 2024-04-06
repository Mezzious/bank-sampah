@extends('layout.app_admin2')

@section('content')
    <h2 style="font-size: 30px;">Laporan Jual Sampah</h2>
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
                        <table id="table_laporan_jual" class="table table-bordered">
                            <thead class="table-secondary">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal_Jual</th>
                                    <th>Pengepul</th>
                                    <th>Jenis_Sampah</th>
                                    <th>Banyak</th>
                                    <th>Harga_Satuan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>11/03/2024</td>
                                    <td>1</td>
                                    <td>Kardus</td>
                                    <td>5Kg</td>
                                    <td>5000</td>
                                    <td>25000</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>11/03/2024</td>
                                    <td>2</td>
                                    <td>Botol</td>
                                    <td>5Kg</td>
                                    <td>3000</td>
                                    <td>15000</td>
                                </tr>
                            </tbody>
                        </table>
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
    </script>
@endsection
