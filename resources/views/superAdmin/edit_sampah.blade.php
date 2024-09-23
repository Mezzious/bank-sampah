@extends('layout.app')

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
        <a class="btn back-button" onclick="goBack()">
            <i class="fa-solid fa-arrow-left" style="color: white;"></i>
            <span style="color: white;">Back</span>
        </a>
    </div>

    <div class="card border-bottom-primary shadow mb-4" style="margin-right: 28px">
        <div class="card-header py-3">
            <h6 class="m-0">Form Edit Data Sampah</h6>
        </div>
        <div class="card-body">
            <form id="editTrashForm" action="{{ route('update_sampah', ['id' => $trashes->id]) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="jenis_sampah">Jenis Sampah*</label>
                    <input type="text" class="form-control" id="jenis_sampah" name="jenis_sampah" required
                        placeholder="Jenis Sampah" value="{{ $trashes->jenis_sampah }}">
                </div>

                <div class="form-group">
                    <label for="satuan">Satuan*</label>
                    <input type="text" class="form-control" id="satuan" name="satuan" required placeholder="Satuan"
                        value="{{ $trashes->satuan }}">
                </div>

                <div class="form-group">
                    <label for="harga">Harga*</label>
                    <input type="text" class="form-control" id="harga" name="harga" required placeholder="Harga"
                        value="{{ $trashes->harga }}">
                </div>

                <div class="form-group">
                    <label for="gambar">Gambar Sampah*</label>
                    <input type="file" class="form-control" name="gambar" placeholder="Masukan file disini"
                        value="{{ $trashes->gambar }}">
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi*</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required placeholder="Deskripsi">{{ $trashes->deskripsi }}</textarea>
                </div>

                <button type="submit" class="btn btn-custom" id="submitButton">Simpan</button>
            </form>
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
            document.getElementById('editTrashForm').addEventListener('submit', function() {
                // Tampilkan overlay dan spinner
                document.getElementById('overlay').style.display = 'block';
                document.getElementById('spinner').style.display = 'block';

                // Disable tombol submit agar tidak bisa diklik lagi
                document.getElementById('submitButton').disabled = true;
            });
        </script>
    @endsection
