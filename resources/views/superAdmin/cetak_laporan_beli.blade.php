@extends('layout.cetak')

@section('content')
    <link rel="stylesheet" href="./assets/compiled/css/all.view.css">
    <hr style="border: 1px solid black">
    <h1 align="center"><b>LAPORAN BELI SAMPAH</b></h1>
    <table id="table_laporan_jual" class="table table-bordered bold-border-table" rules="all" align="center" border="1px"
        style="width: 95%">
        <thead class="table-secondary">
            <tr>
                <th>No</th>
                <th>Tanggal Beli</th>
                <th>Jenis Sampah</th>
                <th>Berat (Kg)</th>
                <th>Harga per Kg (Rp)</th>
                <th>Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach ($saleses as $sales)
                @php
                    $grandTotal += $sales->total;
                    $hargaRp = number_format($sales->harga, 0, ',', '.'); // Ubah harga ke format Rupiah
                    $totalRp = number_format($sales->total, 0, ',', '.'); // Ubah total ke format Rupiah
                @endphp
                <tr align="center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $sales->tanggal_jual }}</td>
                    <td>{{ $sales->jenis_sampah }}</td>
                    <td>{{ $sales->berat }}</td>
                    <td>{{ $hargaRp }}</td>
                    <td>{{ $totalRp }}</td>
                </tr>
            @endforeach
            <tr align="center">
                <td colspan="5" class="text-right font-weight-bold"><b>Jumlah Total</b></td>
                <td colspan="2" class="font-weight-bold"><b>{{ number_format($grandTotal, 0, ',', '.') }}</b></td>
            </tr>
        </tbody>
    </table>
@endsection

@section('script')
    <script>
        window.print();
    </script>
@endsection
