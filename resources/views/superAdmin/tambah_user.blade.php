@extends('layout.app')

@section('content')
    <link rel="stylesheet" href="./assets/compiled/css/all.view.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/5Bl1xZoDvj3FVBIpT9SNq9u/KfAZ5qON6lC7G" crossorigin="anonymous">

    <div class="back-button-container" style="margin-bottom: 15px">
        <a class="btn back-button" onclick="goBack()">
            <i class="fa-solid fa-arrow-left" style="color: white;"></i>
            <span style="color: white;">Back</span>
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card border-bottom-primary shadow mb-4" style="margin-right: 28px">
        <div class="card-header py-3">
            <h6 class="m-0">Form Input Data User</h6>
        </div>
        <div class="card-body">
            <form id="userForm" action="{{ route('store_user') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="nama_user">Nama*</label>
                    <input type="text" class="form-control" id="nama_user" name="name" placeholder="Nama">
                </div>

                <div class="form-group">
                    <label for="email">Email*</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                </div>

                <div class="form-group">
                    <label for="password">Password*</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()" style="background-color: #d3d3d3;">
                            <i class="bi bi-eye-slash" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="roles">Roles*</label>
                    <select class="form-control" id="roles" name="roles">
                        <option value="" disabled selected hidden>Pilih Roles</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->roles }}">{{ ucfirst($role->roles) }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-custom" id="submitBtn">Simpan</button>
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
        // Event listener untuk menampilkan spinner setelah klik tombol submit
        document.getElementById('userForm').addEventListener('submit', function() {
            // Tampilkan spinner
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('spinner').style.display = 'block';

            // Disable tombol submit agar tidak bisa diklik lagi
            document.getElementById('submitBtn').disabled = true;
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
