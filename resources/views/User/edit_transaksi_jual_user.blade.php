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
            <form action="{{ route('update_transaksi_jual_user', ['id' => $sales->id]) }}" method="post">
                @csrf
                @method('PUT')

                {{-- <div class="form-group">
                    <label for="id">Id Jual</label>
                    <input type="text" class="form-control" id="id" name="id" style="cursor: not-allowed;"
                        disabled="disabled" required placeholder="Id Jual">
                </div> --}}

                <div class="form-group">
                    <label for="tanggal_jual">Tanggal Jual*</label>
                    <input type="date" class="form-control" id="tanggal_jual" name="tanggal_jual" value="{{ $sales->tanggal_jual }}" required>
                </div>

                {{-- <div class="form-group">
                    <label for="user_id">User Id*</label>
                    <input type="text" class="form-control" id="user_id" name="user_id" style="cursor: not-allowed;"
                        disabled="disabled" required placeholder="User Id">
                </div> --}}

                <div class="form-group">
                    <label for="jenis_sampah">Jenis Sampah*</label>
                    <input type="text" class="form-control" id="jenis_sampah" name="jenis_sampah" required
                        placeholder="Jenis Sampah" value="{{ $sales->jenis_sampah }}">
                </div>

                <div class="form-group">
                    <label for="berat">Berat (Kg)*</label>
                    <input type="number" step="0.01" class="form-control" onchange="sum();" id="berat" name="berat" required
                        placeholder="Berat" value="{{ $sales->berat }}">
                </div>

                <div class="form-group">
                    <label for="harga">Harga (Rp)*</label>
                    <input type="number" class="form-control" onchange="sum();" id="harga" name="harga" required placeholder="Harga" value="{{ $sales->harga }}">
                </div>

                <div class="form-group">
                    <label for="total">Total (Rp)*</label>
                    <input type="number" class="form-control" onchange="sum();" id="total" name="total" required placeholder="Total" value="{{ $sales->total }}" readonly>
                </div>

                {{-- <div>
                    <div class="form-group">
                        <label for="gambar">Bukti Transaksi Jual*</label>
                        <input type="file" class="form-control" name="upload_bukti_transaksi_jual_link"
                            placeholder="Masukan link disini">
                    </div>
                </div> --}}

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