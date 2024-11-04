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
            justify-content: space-between;
            /* Menjaga jarak antara logo kiri dan kanan */
            align-items: flex-start;
            /* Menyelaraskan kedua logo ke bagian atas */
            width: 100%;
        }

        .logo-kiri img,
        .logo-kanan img {
            width: 70px;
            /* Sesuaikan ukuran logo menjadi sama */
            height: 70px;
            /* Sesuaikan tinggi logo menjadi sama */
            object-fit: contain;
            /* Menjaga proporsi gambar */
        }

        .kop-laporan div {
            margin: 0;
            /* Menghapus margin default */
            padding: 0;
            /* Menghapus padding default */
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
            margin-top: 5px;
            /* Jarak antara logo dan judul */
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
    </style>
</head>

<body>
    <div class="kop-laporan">
        <div class="logo-kiri">
            <img src="./assets/compiled/png/durkep2.png" alt="Logo Kiri">
        </div>
        <!-- Konten Teks di Tengah -->
        <div class="kop-content">
            <h1>BANK SAMPAH</h1>
            <h2>KELURAHAN DURI KEPA</h2>
            <p>JL. KEBON RAYA NO.1 4, RT.4/RW.7, DURI KEPA, KEC. KB. JERUK, KOTA JAKARTA BARAT,<br>
                DAERAH KHUSUS IBUKOTA JAKARTA 11510</p>
        </div>
        <div class="logo-kanan">
            <img src="./assets/compiled/png/jakarta2.png" alt="Logo Kanan">
        </div>
    </div>

    <div class="page-content">
        @yield('content')
    </div>
</body>
@yield('script')

</html>
