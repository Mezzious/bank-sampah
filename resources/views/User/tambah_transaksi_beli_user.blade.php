@extends('layout.app_user')

@section('style')
    <style>
        .signature-pad {
            border: 1px solid black;
            width: 100%;
            height: auto;
            max-width: 100%;
            /* Membatasi agar tidak melebihi kontainer */
            aspect-ratio: 2 / 1;
            /* Menjaga rasio aspek 2:1, bisa disesuaikan */
        }
    </style>
@endsection

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


                @php
                    $today = \Carbon\Carbon::today()->format('Y-m-d');
                @endphp

                <div class="form-group">
                    <label for="tanggal_beli">Tanggal Beli*</label>
                    <input type="date" class="form-control" id="tanggal_beli" name="tanggal_beli"
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

                <div class="form-group">
                    <label for="tanda_tangan">Tanda Tangan*</label><br>
                    <canvas id="signature-pad" class="signature-pad" width=400 height=200
                        style="border: 1px solid black;"></canvas>
                    <input type="hidden" id="tanda_tangan" name="tanda_tangan"><br>
                    <button type="button" class="btn btn-secondary" id="clear-signature">Clear</button>

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
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

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

        // Signature pad logic
        var canvas = document.getElementById('signature-pad');
        var signaturePad = new SignaturePad(canvas);

        document.getElementById('clear-signature').addEventListener('click', function() {
            signaturePad.clear();
        });

        document.querySelector('form').addEventListener('submit', function(event) {
            if (signaturePad.isEmpty()) {
                event.preventDefault();
                alert('Tanda tangan dibutuhkan.');
            } else {
                var signatureData = signaturePad.toDataURL();
                document.getElementById('tanda_tangan').value = signatureData;
            }
        });

        // Function to resize the canvas
        function resizeCanvas() {
            var canvas = document.getElementById('signature-pad');
            var ratio = Math.max(window.devicePixelRatio || 1, 1);
            // Resize canvas based on its container
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear(); // Clear the canvas when resized
        }

        // Initialize signature pad
        var canvas = document.getElementById('signature-pad');
        var signaturePad = new SignaturePad(canvas);

        // Resize the canvas on page load and when window is resized
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas(); // Call it once on load

        // Clear signature logic
        document.getElementById('clear-signature').addEventListener('click', function() {
            signaturePad.clear();
        });

        // Submit logic
        document.querySelector('form').addEventListener('submit', function(event) {
            if (signaturePad.isEmpty()) {
                event.preventDefault();
                alert('Tanda tangan dibutuhkan.');
            } else {
                var signatureData = signaturePad.toDataURL();
                document.getElementById('tanda_tangan').value = signatureData;
            }
        });
    </script>

    <script>
        document.querySelector('form').addEventListener('submit', function() {
            // Tampilkan spinner dan overlay
            document.getElementById('spinner').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';

            // Nonaktifkan tombol submit
            document.querySelector('.btn-custom').disabled = true;
        });
    </script>
@endsection
