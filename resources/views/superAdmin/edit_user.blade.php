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
            <h6 class="m-0">Form Edit Data User</h6>
        </div>
        <div class="card-body">
            <form action="/admin/store" method="post">
                @csrf

                <div class="form-group">
                    <label for="id_user">Id User</label>
                    <input type="text" class="form-control" id="id_user" name="id_user" style="cursor: not-allowed;"
                        disabled="disabled" required placeholder="Id User">
                </div>

                <div class="form-group">
                    <label for="nama_user">Nama*</label>
                    <input type="text" class="form-control" id="nama_user" name="nama_user" required placeholder="Nama">
                </div>

                <div class="form-group">
                    <label for="telepon">Telepon*</label>
                    <input type="text" class="form-control" id="telepon" name="telepon" required
                        placeholder="Nomor Telepon">
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
                    <label for="level">Level*</label>
                    <select class="form-control" id="level" name="level" required>
                        <option value="" disabled selected hidden>Pilih Level</option>
                        <option value="admin">Super Admin</option>
                        <option value="superadmin">Admin</option>
                        <option value="superadmin">User</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-custom">Simpan</button>
            </form>
        </div>
    </div>
@endsection
