@extends('layout.cetak')
@section('content')
    <div align="center">
        <h1> {{$data['divisi']}} </h1>
        <h1> {{$data['nama_kelurahan']}} </h1>
        <p> {{$data['alamat']}} </p>
        <hr style="border: 1px solid black">
    </div>
@endsection

@section('script')
    
@endsection