@extends('layout.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/all.view.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/5Bl1xZoDvj3FVBIpT9SNq9u/KfAZ5qON6lC7G" crossorigin="anonymous">

    <div class="back-button-container" style="margin-bottom: 15px">
        <a href="{{ route('dashboard_superadmin') }}" class="btn back-button">
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

    @if (session('status'))
        <div class="alert alert-danger" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-primary" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card" style="margin-right: 28px">
        <div class="card-header" style="color: #4F6F52; font-weight: bold; font-size: 20px; font-family: sans-serif;">
            Ganti Password
        </div>

        <div class="card-body">
            <form id="passwordForm" method="POST" action="{{ route('update_password') }}">
                @csrf

                <div class="form-group row">
                    <label for="current_password" class="col-md-4 col-form-label text-md-right">Password Saat Ini</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input id="current_password" type="password"
                                class="form-control @error('current_password') is-invalid @enderror" name="current_password"
                                autocomplete="current-password">
                            <button class="btn btn-outline-secondary" type="button"
                                onclick="togglePassword('current_password')" style="background-color: #d3d3d3;">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">Password Baru</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                autocomplete="new-password">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')"
                                style="background-color: #d3d3d3;">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Konfirmasi Password
                        Baru</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                autocomplete="new-password">
                            <button class="btn btn-outline-secondary" type="button"
                                onclick="togglePassword('password-confirm')" style="background-color: #d3d3d3;">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Ganti Password
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Overlay and Spinner -->
        <div id="overlay"></div>
        <div id="spinner" class="spinner-border text-success" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
@endsection

@section('script')
    <!-- Toggle Password Visibility Script -->
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = input.nextElementSibling.querySelector('i');
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        }

        document.getElementById('passwordForm').addEventListener('submit', function() {
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('spinner').style.display = 'block';
        });
    </script>
@endsection
