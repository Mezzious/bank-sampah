@extends('layout.app_user')

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
            <h6 class="m-0">Form Input Transaksi Beli</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('store_transaksi_beli') }}" method="post" enctype="multipart/form-data">
                @csrf

                {{-- <div class="form-group">
                    <label for="id">Id Jual</label>
                    <input type="text" class="form-control" id="id" name="id" style="cursor: not-allowed;"
                        disabled="disabled" required placeholder="Id Jual">
                </div> --}}

                {{-- <div class="form-group">
                    <label for="user_id">User Id*</label>
                    <input type="text" class="form-control" id="user_id" name="user_id" style="cursor: not-allowed;"
                    disabled="disabled" required placeholder="User Id">
                </div> --}}

                @php
                    $today = \Carbon\Carbon::today()->format('Y-m-d');
                @endphp

                <div class="form-group">
                    <label for="tanggal_jual">Tanggal Beli*</label>
                    <input type="date" class="form-control" id="tanggal_jual" name="tanggal_jual"
                        value="{{ $today }}" required>
                </div>

                <div class="form-group">
                    <label for="jenis_sampah">Jenis Sampah*</label>
                    <select class="form-control" id="jenis_sampah" name="jenis_sampah" required
                        onchange="updateSampahDetails()">
                        <option value="">Pilih Jenis Sampah</option>
                        @foreach ($trashes as $trash)
                            <option value="{{ $trash->jenis_sampah }}">
                                {{ $trash->jenis_sampah }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="berat">Berat (Kg)*</label>
                    <input type="number" class="form-control" id="berat" onchange="sum();" name="berat" required
                        placeholder="Berat">
                </div>

                <div class="form-group">
                    <label for="harga">Harga (Rp)*</label>
                    <input type="number" class="form-control" id="harga" onchange="sum();" name="harga" required
                        placeholder="Harga">
                </div>

                <div class="form-group">
                    <label for="total">Total (Rp)*</label>
                    <input type="number" class="form-control" id="total" onchange="sum();" name="total" readonly
                        disabled placeholder="Total">
                </div>

                <div>
                    <div class="form-group">
                        <label for="gambar">Gambar Sampah*</label>
                        <input type="file" class="form-control" name="gambar" placeholder="Masukan link disini">
                    </div>
                </div>

                <div>
                    <div class="form-group">
                        <label for="nota">Gambar Nota*</label>
                        <input type="file" class="form-control" name="nota" placeholder="Masukan link disini">
                    </div>
                </div>

                <button type="submit" class="btn btn-custom">Simpan</button>
            </form>
        </div>
    </div>
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
    </script>
    <script>
        // Event listener untuk menampilkan spinner setelah klik tombol submit
        document.getElementById('userForm').addEventListener('submit', function() {
            // Tampilkan spinner
            document.getElementById('spinner').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
            // Disable tombol submit agar tidak bisa diklik lagi
            document.getElementById('submitBtn').disabled = true;
        });
    </script>
@endsection
