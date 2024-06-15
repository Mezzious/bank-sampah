@extends('layout.cetak')

@section('content')
    <h1 align="center"><b>Laporan Beli Sampah</b></h1>
    <table id="table_laporan_beli" class="table table-bordered" rules="all" align="center" border="1px" style="width: 95%">
        <thead class="table-secondary">
            <tr>
                <th>No</th>
                <th>RW</th>
                <th>Tanggal Beli</th>
                <th>Jenis Sampah</th>
                <th>Berat (Kg)</th>
                <th>Harga per Kg (Rp)</th>
                <th>Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach ($purchases as $purchase)
                @php 
                $grandTotal += $purchase->total; 
                $hargaRp = number_format($purchase->harga, 0, ',', '.'); // Ubah harga ke format Rupiah
                $totalRp = number_format($purchase->total, 0, ',', '.'); // Ubah total ke format Rupiah
                @endphp
                <tr align="center">
                    <td>{{ $loop->iteration }}</td>
                    <td>0{{ $purchase->user->customer->rw }}</td>
                    <td>{{ $purchase->tanggal_beli }}</td>
                    <td>{{ $purchase->jenis_sampah }}</td>
                    <td>{{ $purchase->berat }}</td>
                    <td>{{ $hargaRp }}</td>
                    <td>{{ $totalRp }}</td>
                </tr>
            @endforeach
            <tr align="center">
                <td colspan="6" class="text-right font-weight-bold"><b>Jumlah Total</b></td>
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