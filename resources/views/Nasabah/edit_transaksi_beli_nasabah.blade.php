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
            <h6 class="m-0">Form Edit Transaksi Beli</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('update_transaksi_beli_nasabah', ['id' => $purchase->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                {{-- <div class="form-group">
                    <label for="id">Id Beli</label>
                    <input type="text" class="form-control" id="id" name="id" style="cursor: not-allowed;"
                        disabled="disabled" required placeholder="Id Beli">
                </div> --}}

                <div class="form-group">
                    <label for="tanggal_beli">Tanggal Beli*</label>
                    <input type="date" class="form-control" id="tanggal_beli" name="tanggal_beli" value="{{ $purchase->tanggal_beli }}" required>
                </div>

                {{-- <div class="form-group">
                    <label for="customer_id">Customer Id*</label>
                    <input type="date" class="form-control" id="customer_id" name="customer_id" style="cursor: not-allowed;"
                    disabled="disabled" required>
                </div> --}}

                <div class="form-group">
                    <label for="jenis_sampah">Jenis Sampah*</label>
                    <input type="text" class="form-control" id="jenis_sampah" name="jenis_sampah" value="{{ $purchase->jenis_sampah }}" required
                        placeholder="Jenis Sampah">
                </div>

                <div class="form-group">
                    <label for="berat">Berat (Kg)*</label>
                    <input type="number" step="0.01" class="form-control" id="berat" onchange="sum();" name="berat" value="{{ $purchase->berat }}" required
                        placeholder="Berat">
                </div>

                <div class="form-group">
                    <label for="harga">Harga (Rp)*</label>
                    <input type="number" class="form-control" id="harga" onchange="sum();" name="harga" value="{{ $purchase->harga }}" required placeholder="Harga">
                </div>

                <div class="form-group">
                    <label for="total">Total (Rp)*</label>
                    <input type="number" class="form-control" id="total" onchange="sum();" name="total" value="{{ $purchase->total }}" required placeholder="Total">
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