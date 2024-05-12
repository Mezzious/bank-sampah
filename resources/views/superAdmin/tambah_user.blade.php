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
            <h6 class="m-0">Form Input Data User</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('store_user') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="nama_user">Nama*</label>
                    <input type="text" class="form-control" id="nama_user" name="name" required placeholder="Nama">
                </div>

                <div class="form-group">
                    <label for="email">Email*</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="Email">
                </div>

                <div class="form-group">
                    <label for="password">Password*</label>
                    <input type="password" class="form-control" id="password" name="password" required
                        placeholder="Password">
                </div>

                <div class="form-group">
                    <label for="roles">Roles*</label>
                    <select class="form-control" id="roles" name="roles" required>
                        <option value="" disabled selected hidden>Pilih Roles</option>
                        <option value="super-admin">Super Admin</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-custom">Simpan</button>
            </form>
        </div>
    </div>
@endsection
