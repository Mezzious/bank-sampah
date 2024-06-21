@extends('layout.app_user')

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
            <h6 class="m-0">Form Edit Transaksi Jual</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('update_transaksi_beli_user', ['id' => $sales->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
            
                @php
                    $today = \Carbon\Carbon::today()->format('Y-m-d');
                @endphp

                <div class="form-group">
                    <label for="tanggal_jual">Tanggal Jual*</label>
                    <input type="date" class="form-control" id="tanggal_jual" name="tanggal_jual" value="{{ $today }}" required>
                </div>
            
                <div class="form-group">
                    <label for="jenis_sampah">Jenis Sampah*</label>
                    <select class="form-control" id="jenis_sampah" name="jenis_sampah" required onchange="updateSampahDetails()">
                        <option value="">Pilih Jenis Sampah</option>
                        @foreach($trashes as $trash)
                            <option value="{{ $trash->jenis_sampah }}">
                                {{ $trash->jenis_sampah }}
                            </option>
                        @endforeach
                    </select>
                </div>
            
                <div class="form-group">
                    <label for="berat">Berat (Kg)*</label>
                    <input type="number" step="0.01" class="form-control" onchange="sum();" id="berat" name="berat" required placeholder="Berat" value="{{ $sales->berat }}">
                </div>
            
                <div class="form-group">
                    <label for="harga">Harga (Rp)*</label>
                    <input type="number" class="form-control" onchange="sum();" id="harga" name="harga" required placeholder="Harga" value="{{ $sales->harga }}">
                </div>
            
                <div class="form-group">
                    <label for="total">Total (Rp)*</label>
                    <input type="number" class="form-control" onchange="sum();" id="total" name="total" required disabled placeholder="Total" value="{{ $sales->total }}" readonly>
                </div>
            
                <div class="form-group">
                    <label for="gambar_sampah">Gambar Sampah</label>
                    <input type="file" class="form-control" id="gambar_sampah" name="gambar_sampah">
                </div>
            
                <div class="form-group">
                    <label for="gambar_nota">Gambar Nota</label>
                    <input type="file" class="form-control" id="gambar_nota" name="gambar_nota">
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
</script>
@endsection