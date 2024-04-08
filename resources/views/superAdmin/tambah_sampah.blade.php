@extends('layout.app')

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
            <h6 class="m-0">Form Input Data Sampah</h6>
        </div>
        <div class="card-body">
            <form action="/sampah/store" method="post">
                @csrf

                {{-- <div class="form-group">
                    <label for="id">Id Sampah</label>
                    <input type="text" class="form-control" id="id" name="id" style="cursor: not-allowed;"
                        disabled="disabled" required placeholder="Id Sampah">
                </div> --}}

                <div class="form-group">
                    <label for="user_id">User Id</label>
                    <input type="text" class="form-control" id="user_id" name="user_id" style="cursor: not-allowed;"
                        disabled="disabled" required placeholder="User Id">
                </div>

                <div class="form-group">
                    <label for="jenis_sampah">Jenis Sampah*</label>
                    <input type="text" class="form-control" id="jenis_sampah" name="jenis_sampah" required
                        placeholder="Jenis Sampah">
                </div>

                <div class="form-group">
                    <label for="satuan">Satuan*</label>
                    <input type="text" class="form-control" id="satuan" name="satuan" required placeholder="Satuan">
                </div>

                <div class="form-group">
                    <label for="harga">Harga*</label>
                    <input type="text" class="form-control" id="harga" name="harga" required placeholder="Harga">
                </div>

                <div>
                    <div class="form-group">
                    <label for="gambar">Gambar Sampah*</label>
                    <input type="file" class="form-control" name="upload_gambar_sampah_link" placeholder="Masukan file disini">
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi*</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required placeholder="Deskripsi"></textarea>
                </div>


                <button type="submit" class="btn btn-custom">Simpan</button>
            </form>
        </div>
    </div>
@endsection
