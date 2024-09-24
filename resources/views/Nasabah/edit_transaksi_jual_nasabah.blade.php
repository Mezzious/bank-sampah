@extends('layout.app_nasabah')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <link rel="stylesheet" href="./assets/compiled/css/all.view.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/5Bl1xZoDvj3FVBIpT9SNq9u/KfAZ5qON6lC7G" crossorigin="anonymous">
    <div class="back-button-container" style="margin-bottom: 15px">
        <a class="btn back-button" onclick="goBack()">
            <i class="fa-solid fa-arrow-left" style="color: white;"></i>
            <span style="color: white;">Back</span>
        </a>
    </div>

    <div class="card border-bottom-primary shadow mb-4" style="margin-right: 28px">
        <div class="card-header py-3">
            <h6 class="m-0">Form Edit Transaksi Jual</h6>
        </div>
        <div class="card-body">
            <form id="myForm" action="{{ route('update_transaksi_jual_nasabah', ['id' => $purchase->id]) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @php
                    $today = \Carbon\Carbon::today()->format('Y-m-d');
                @endphp

                <div class="form-group">
                    <label for="tanggal_beli">Tanggal Jual*</label>
                    <input type="date" class="form-control" id="tanggal_beli" name="tanggal_beli"
                        value="{{ $today }}" required>
                </div>

                <div class="form-group">
                    <label for="jenis_sampah">Jenis Sampah*</label>
                    <select class="form-control" id="jenis_sampah" name="jenis_sampah" required
                        onchange="updateSampahDetails()">
                        <option value="">Pilih Jenis Sampah</option>
                        @foreach ($trashes as $trash)
                            <option value="{{ $trash->jenis_sampah }}" data-harga="{{ $trash->harga }}">
                                {{ $trash->jenis_sampah }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="berat">Berat (Kg)*</label>
                    <input type="number" step="0.01" class="form-control" id="berat" onchange="sum();"
                        name="berat" value="{{ $purchase->berat }}" required placeholder="Berat">
                </div>

                <div class="form-group">
                    <label for="harga">Harga (Rp)*</label>
                    <input type="number" class="form-control" id="harga" onchange="sum();" name="harga"
                        value="{{ $purchase->harga }}" required placeholder="Harga" readonly>
                </div>

                <div class="form-group">
                    <label for="total">Total (Rp)*</label>
                    <input type="number" class="form-control" id="total" onchange="sum();" name="total"
                        value="{{ $purchase->total }}" required placeholder="Total" readonly>
                </div>

                <div class="form-group">
                    <label for="gambar_sampah">Gambar Sampah</label>
                    <input type="file" class="form-control" id="gambar_sampah" name="gambar_sampah">
                </div>

                <button type="submit" class="btn btn-custom">Simpan</button>
            </form>

            <!-- Overlay di Tengah Layar -->
            <div id="overlay"></div>
            <!-- Spinner di Tengah Layar -->
            <div id="spinner" class="spinner-border text-success" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        @endsection

        @section('script')
            <script>
                function sum() {
                    var txtFirstNumberValue = document.getElementById('berat').value;
                    console.log(txtFirstNumberValue)
                    var txtSecondNumberValue = document.getElementById('harga').value;
                    console.log(txtSecondNumberValue)
                    var result = parseInt(txtFirstNumberValue) * parseInt(txtSecondNumberValue);
                    if (!isNaN(result)) {
                        document.getElementById('total').value = result;
                    }
                }

                function updateSampahDetails() {
                    var select = document.getElementById('jenis_sampah');
                    var selectedOption = select.options[select.selectedIndex];
                    var harga = selectedOption.getAttribute('data-harga');
                    var gambar = selectedOption.getAttribute('data-gambar');

                    document.getElementById('harga').value = harga;
                    document.getElementById('gambar').value = gambar;
                }

                document.getElementById('myForm').addEventListener('submit', function(event) {
                    // Show overlay and spinner
                    document.getElementById('overlay').style.display = 'block';
                    document.getElementById('spinner').style.display = 'block';
                });
            </script>
        @endsection
