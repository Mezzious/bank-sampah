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

    <div class="back-button-container" style="margin-bottom: 15px">
        <a class="btn back-button" onclick="goBack()">
            <i class="fa-solid fa-arrow-left" style="color: white;"></i>
            <span style="color: white;">Back</span>
        </a>
    </div>

    <div class="card border-bottom-primary shadow mb-4" style= "margin-right: 28px">

        <div class="card-header py-3">
            <h6 class="m-0">Form Edit Data Nasabah</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('update_nasabah', ['id' => $customer->id]) }}" method="post">
                @csrf
                @method('PUT')

                {{-- <div class="form-group">
                    <label for="id">Id Nasabah</label>
                    <input type="text" class="form-control" id="id" name="id"
                        style="cursor: not-allowed;" disabled="disabled" required placeholder="Id Nasabah">
                </div> --}}

                {{-- <div class="form-group">
                    <label for="customer_id">Customer_Id</label>
                    <input type="text" class="form-control" id="customer_id" name="customer_id"
                        style="cursor: not-allowed;" disabled="disabled" required placeholder="Customer_Id">
                </div> --}}

                <div class="form-group">
                    <label for="nama_nasabah">Nama*</label>
                    <input type="text" class="form-control" id="nama_nasabah" name="nama_nasabah" required
                        placeholder="Nama" value="{{ $user->name }}">
                </div>

                <div class="form-group">
                    <label for="email">Email*</label>
                    <input type="text" class="form-control" id="email" name="email" required
                        placeholder="Email" value="{{ $user->email }}">
                </div>

                <div class="form-group">
                    <label for="RW">RW*</label>
                    <input type="text" class="form-control" id="RW" name="RW" required placeholder="RW" value="{{ $customer->rw }}">
                </div>

                <div class="form-group">
                    <label for="telepon">Telepon*</label>
                    <input type="text" class="form-control" id="telepon" name="telepon" required placeholder="telepon" value="{{ $customer->telepon }}">
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat*</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required placeholder="Alamat lengkap">{{ $customer->alamat }}</textarea>
                </div>

                <button type="submit" class="btn btn-custom">Simpan</button>
            </form>
        </div>
    </div>
@endsection
