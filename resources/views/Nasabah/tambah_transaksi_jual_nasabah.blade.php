@extends('layout.app_nasabah')

@section('style')
    <style>
        .signature-pad {
            border: 1px solid black;
            width: 100%;
            height: auto;
            max-width: 100%;
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

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <link rel="stylesheet" href="./assets/compiled/css/all.view.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/5Bl1xZoDvj3FVBIpT9SNq9u/KfAZ5qON6lC7G" crossorigin="anonymous">
    <div class="back-button-container" style="margin-bottom: 15px">
        <a href="{{ route('transaksi_jual_nasabah') }}" class="btn back-button">
            <i class="fa-solid fa-arrow-left" style="color: white;"></i>
            <span style="color: white;">Back</span>
        </a>
    </div>

    <div class="card border-bottom-primary shadow mb-4" style="margin-right: 28px">
        <div class="card-header py-3">
            <h6 class="m-0">Form Input Transaksi Jual</h6>
        </div>
        <div class="card-body">
            <form id="transaction-form" action="{{ route('store_transaksi_jual') }}" method="post"
                enctype="multipart/form-data">
                @csrf

                @php
                    $today = \Carbon\Carbon::today()->format('Y-m-d');
                @endphp

                <div class="form-group">
                    <label for="tanggal_jual">Tanggal Jual*</label>
                    <input type="date" class="form-control" id="tanggal_jual" name="tanggal_jual"
                        value="{{ $today }}">
                </div>

                <div class="form-group">
                    <label for="jenis_sampah">Jenis Sampah*</label>
                    <select class="form-control" id="jenis_sampah" name="jenis_sampah" onchange="updateSampahDetails()">
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
                    <input type="number" min="1" max="999" class="form-control" id="berat"
                        onchange="sum();" name="berat" placeholder="Berat">
                </div>

                <div class="form-group">
                    <label for="harga">Harga (Rp)*</label>
                    <input type="number" class="form-control" id="harga_display" onchange="sum();" name="harga" disabled
                        placeholder="Harga" readonly>
                    <input type="hidden" id="harga" name="harga">
                </div>

                <div class="form-group">
                    <label for="total">Total (Rp)*</label>
                    <input type="number" class="form-control" id="total" onchange="sum();" name="total" disabled
                        placeholder="Total" readonly>
                </div>

                <div class="form-group">
                    <label for="gambar">Gambar Sampah*</label>
                    <input type="file" class="form-control" name="gambar" placeholder="Masukan link disini">
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
            var berat = document.getElementById('berat').value;
            var harga = document.getElementById('harga').value;
            var result = parseInt(berat) * parseInt(harga);
            if (!isNaN(result)) {
                document.getElementById('total').value = result;
            }
        }

        function updateSampahDetails() {
            var select = document.getElementById('jenis_sampah');
            var selectedOption = select.options[select.selectedIndex];
            var harga = selectedOption.getAttribute('data-harga');

            document.getElementById('harga').value = harga;
            document.getElementById('harga_display').value = harga;
        }

        // Signature pad logic
        var canvas = document.getElementById('signature-pad');
        var signaturePad = new SignaturePad(canvas);

        document.getElementById('clear-signature').addEventListener('click', function() {
            signaturePad.clear();
        });

        document.getElementById('transaction-form').addEventListener('submit', function(event) {
            // Periksa apakah tanda tangan kosong
            if (signaturePad.isEmpty()) {
                event.preventDefault();
                alert('Tanda tangan dibutuhkan.');
                return; // Hentikan eksekusi jika validasi gagal
            }

            // Set tanda tangan ke input hidden
            var signatureData = signaturePad.toDataURL();
            document.getElementById('tanda_tangan').value = signatureData;

            // Tampilkan overlay dan spinner hanya jika validasi lolos
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('spinner').style.display = 'block';

            // Nonaktifkan tombol submit untuk mencegah klik ulang
            document.querySelector('.btn-custom').disabled = true;
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

        // Resize the canvas on page load and when window is resized
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas(); // Call it once on load
    </script>
@endsection
