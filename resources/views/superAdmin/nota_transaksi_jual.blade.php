@extends('layout.nota')

@section('content')
<div class="nota-container">
    <div class="header" align="center">
        <h1>BANK SAMPAH KELURAHAN DURI KEPA</h1>
        <p>Jl. Kebon Raya No.1 4, RT.4/RW.7, Duri Kepa, Kec. Kb. Jeruk,</p>
        <p>Jakarta Barat, DKI Jakarta 11510</p>
    </div>

    <hr style="border: 1px dashed black">

    <h2 align="center"><b>NOTA PENJUALAN SAMPAH</b></h2>

    <table style="width: 100%;">
        <tr>
            <td>RW: 0{{ $purchases->user->customer->rw }}</td>
            <td align="right">Harga: {{ $purchases->harga }} / Kg</td>
        </tr>
        <tr>
            <td> Tanggal: {{ $purchases->tanggal_beli }} </td>
            <td align="right">Berat: {{ $purchases->berat }} Kg</td>
        </tr>
        <tr>
            <td>Jenis Sampah: {{ $purchases->jenis_sampah }}</td>
            <td align="right">Total: {{ $purchases->total }} </td>
        </tr>
    </table>

    <hr style="border: 1px dashed black; margin: 10px 0;">

    <div class="footer">
        <div style="float: left; text-align: center; width: 45%;">
            <p>Nasabah</p>
            <p>({{ $purchases->user->name }})</p>
        </div>
        <div style="float: right; text-align: center; width: 45%;">
            <p>Petugas Bank Sampah</p>
            <img src="{{ asset('storage/assets/tanda_tangan_beli/' . $purchases->gambar_ttd) }}" alt="Tanda Tangan" style="max-width: 100px; max-height: 50px;">
            <p> ({{ $superadmin->name }}) </p>
        </div>
    </div>

    <div style="clear: both;"></div>
</div>
@endsection
