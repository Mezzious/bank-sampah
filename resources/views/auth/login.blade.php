<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/compiled/css/style-login.css">
    <title>Login KepaEcoBank</title>
</head>

<body>

    <!----------------------- Main Container -------------------------->

    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <!-- Login Container -->
        <div class="row border rounded-5 p-3 bg-white shadow box-area"{{ __('Login') }}>

            <!-- Left Box -->
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box"
                style="background: #D3E3C8;">
                <div class="featured-image mb-3">
                    <img src="./assets/compiled/png/logo3.png" class="img-fluid" style="width: 350px;">
                </div>
            </div>

            <!-- Right Box -->
            <div class="col-md-6 right-box">
                <div class="row align-items-center">

                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dimissible fade show" role="alert">
                            {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                    @endif

                    <div class="header-text mb-4">
                        <h2>Hello,Again</h2>
                        <p>We are happy to have you back.</p>
                    </div>

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="" class="w-100">
                        @csrf

                        <div class="input-group mb-3">
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror form-control-lg bg-light fs-6"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                placeholder="Email address">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-1">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror form-control-lg bg-light fs-6"
                                name="password" required autocomplete="current-password" placeholder="Password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-5 d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember"
                                    class="form-check-label text-secondary"><small>{{ __('Remember Me') }}</small></label>
                            </div>
                            <a href="/storage/assets/panduan/panduan.pdf" target="_blank" class="text-secondary">
                                <small>Buku Panduan</small>
                            </a>
                        </div>

                        <div class="input-group mb-3">
                            <button type="submit"
                                class="btn btn-lg w-100 fs-6" style=" color: white; background-color:#4F6F52 ">{{ __('Login') }}</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</body>

</html>