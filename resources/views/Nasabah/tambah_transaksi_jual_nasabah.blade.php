@extends('layout.app_nasabah')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <link rel="stylesheet" href="./assets/compiled/css/all.view.css">

    <div class="back-button-container" style="margin-bottom: 15px">
        <a class="btn back-button" onclick="goBack()">
            <i class="fa-solid fa-arrow-left" style="color: white;"></i>
            <span style="color: white;">Back</span>
        </a>
    </div>

    <div class="card border-bottom-primary shadow mb-4" style="margin-right: 28px">
        <div class="card-header py-3">
            <h6 class="m-0">Form Input Transaksi Jual</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('store_transaksi_jual') }}" method="post" enctype="multipart/form-data">
                @csrf

                {{-- <div class="form-group">
                    <label for="id">Id Beli</label>
                    <input type="text" class="form-control" id="id" name="id" style="cursor: not-allowed;"
                        disabled="disabled" required placeholder="Id Beli">
                </div> --}}

                <div class="form-group">
                    <label for="tanggal_beli">Tanggal Jual*</label>
                    <input type="date" class="form-control" id="tanggal_beli" name="tanggal_beli" required>
                </div>

                {{-- <div class="form-group">
                    <label for="customer_id">Customer Id*</label>
                    <input type="text" class="form-control" id="customer_id" name="customer_id" style="cursor: not-allowed;"
                    disabled="disabled" required>
                </div> --}}

                <div class="form-group">
                    <label for="jenis_sampah">Jenis Sampah*</label>
                    <select class="form-control" id="jenis_sampah" name="jenis_sampah" required onchange="updateSampahDetails()">
                        <option value="">Pilih Jenis Sampah</option>
                        @foreach($trashes as $trash)
                            <option value="{{ $trash->jenis_sampah }}" data-harga="{{ $trash->harga }}">
                                {{ $trash->jenis_sampah }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="berat">Berat (Kg)*</label>
                    <input type="number" step="0.01" class="form-control" id="berat" onchange="sum();" name="berat" required
                        placeholder="Berat">
                </div>

                <div class="form-group">
                    <label for="harga">Harga (Rp)*</label>
                    <input type="number" class="form-control" id="harga" onchange="sum();" name="harga" required placeholder="Harga" readonly>
                </div>

                <div class="form-group">
                    <label for="total">Total (Rp)*</label>
                    <input type="number" class="form-control" id="total" onchange="sum();" name="total" required placeholder="Total" readonly>
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
            document.getElementById('total').value=result;
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
@endsection