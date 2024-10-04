<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan</title>
    <link rel="icon" href="./favicon.ico">
    <style>
        .kop-laporan {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 20px 0;
            margin-bottom: 5px;
        }

        .kop-laporan h1,
        .kop-laporan h2,
        .kop-laporan p {
            text-align: center;
            margin: 0;
        }

        .kop-laporan h1 {
            font-size: 28px;
            font-weight: bold;
        }

        .kop-laporan h2 {
            font-size: 24px;
            margin: 5px 0;
        }

        .kop-laporan p {
            font-size: 16px;
            line-height: 1.5;
        }

        .kop-content {
            text-align: center;
            flex-grow: 1;
            /* Teks berada di tengah antara dua logo */
        }

        .kop-laporan img {
            max-width: 80px;
            /* Sesuaikan ukuran logo */
            height: auto;
        }
    </style>
</head>

<body>
    <div class="kop-laporan">
        <!-- Logo Kiri -->
        <img src="./assets/compiled/png/durkep.png" alt="Logo Kiri" style="height: 65px; width: 65px;">

        <!-- Konten Teks di Tengah -->
        <div class="kop-content">
            <h1>BANK SAMPAH</h1>
            <h2>KELURAHAN DURI KEPA</h2>
            <p>JL. KEBON RAYA NO.1 4, RT.4/RW.7, DURI KEPA, KEC. KB. JERUK, KOTA JAKARTA BARAT,<br>
                DAERAH KHUSUS IBUKOTA JAKARTA 11510</p>
        </div>

        <!-- Logo Kanan -->
        <img src="./assets/compiled/png/jakarta.png" alt="Logo Kanan" style="height: 95px; width: 95px;">
    </div>

    <div class="page-content">
        @yield('content')
    </div>
</body>
    @yield('script')
</html>
