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
        <a href="{{ route('data_nasabah') }}" class="btn back-button">
            <i class="fa-solid fa-arrow-left" style="color: white;"></i>
            <span style="color: white;">Back</span>
        </a>
    </div>

    <div class="card border-bottom-primary shadow mb-4" style="margin-right: 28px">
        <div class="card-header py-3">
            <h6 class="m-0">Form Input Data Nasabah</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('store_nasabah') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="nama_nasabah">Nama*</label>
                    <input type="text" class="form-control" id="nama_nasabah" name="nama_nasabah"
                        placeholder="Nama">
                </div>

                <div class="form-group">
                    <label for="email">Email*</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                </div>

                <div class="form-group">
                    <label for="password">Password*</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Password">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()" style="background-color: #d3d3d3;">
                            <i class="bi bi-eye-slash" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="RW">RW*</label>
                    <input type="text" class="form-control" id="RW" name="RW" placeholder="RW">
                </div>

                <div class="form-group">
                    <label for="telepon">Telepon*</label>
                    <input type="text" class="form-control" id="telepon" name="telepon" placeholder="telepon">
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat*</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Alamat lengkap"></textarea>
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
        document.querySelector('form').addEventListener('submit', function() {
            // Tampilkan spinner dan overlay
            document.getElementById('spinner').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';

            // Nonaktifkan tombol submit
            document.querySelector('.btn-custom').disabled = true;
        });
    </script>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("bi-eye-slash");
                eyeIcon.classList.add("bi-eye");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("bi-eye");
                eyeIcon.classList.add("bi-eye-slash");
            }
        }
    </script>
@endsection
