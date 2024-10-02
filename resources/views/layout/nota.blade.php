<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Nota</title>
    <link rel="icon" href="./favicon.ico">

    {{-- <link rel="stylesheet" href="./assets/compiled/css/all.view.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="shortcut icon" href="./assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon"
        href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC"
        type="image/png">

    <!-- Custom fonts for this template-->
    <link href="resources/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="resources/css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="./assets/compiled/css/iconly.css"> --}}
    <style>
        .kop-laporan {
            text-align: center;
            width: 100%;
            /* Lebar penuh untuk menempatkan kop di tengah */
            padding: 20px 0;
            /* Memberi jarak atas dan bawah */
            margin-bottom: 5px;
            /* Memberi jarak dari elemen di bawahnya */
        }

        .kop-laporan h1 {
            font-size: 28px;
            /* Ukuran font judul utama */
            margin: 0;
            /* Menghilangkan margin default */
            font-weight: bold;
            /* Membuat teks lebih tebal */
        }

        .kop-laporan h2 {
            font-size: 24px;
            /* Ukuran font sub-judul */
            margin: 5px 0;
            /* Jarak antara judul utama dan sub-judul */
            /* font-weight: normal; Menjaga agar tidak terlalu tebal */
        }

        .kop-laporan p {
            font-size: 16px;
            /* Ukuran font untuk alamat */
            margin: 10px 0;
            /* Memberi jarak pada paragraf */
            line-height: 1.5;
            /* Mengatur jarak antar-baris agar lebih enak dibaca */
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            width: 58mm;
            margin: 0;
            padding: 0;
        }

        .nota-container {
            padding: 5px;
        }

        .header h1 {
            margin: 0;
            font-size: 13px;
        }

        .header p {
            margin: 0;
            font-size: 9px;
        }

        h2 {
            font-size: 12px;
            margin: 10px 0;
        }

        table {
            width: 100%;
            font-size: 11px;
            border-collapse: collapse;
        }

        table td {
            padding: 3px 0;
        }

        hr {
            margin: 10px 0;
        }

        .footer {
            margin-top: 15px;
            width: 100%;
        }

        .footer div {
            width: 45%;
            display: inline-block;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>

<body>
    {{-- <script src="assets/static/js/initTheme.js"></script> --}}

    {{-- <div class="kop-laporan">
        <h1>BANK SAMPAH</h1>
        <h2>KELURAHAN DURI KEPA</h2>
        <h2>JL. KEBON RAYA NO.1 4, RT.4/RW.7, DURI KEPA, KEC. KB. JERUK, KOTA JAKARTA BARAT, <BR> DAERAH KHUSUS IBUKOTA JAKARTA 11510</h2>
    </div> --}}

    <div class="page-content">
        @yield('content')
    </div>

    @yield('style')
    {{-- <script src="assets/static/js/components/dark.js"></script>
        <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>


        <script src="assets/compiled/js/app.js"></script>

        <!-- Bootstrap core JavaScript-->
        <script src="resources/js/jquery.min.js"></script>
        <script src="resources/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="resources/js/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="resources/js/sb-admin-2.min.js"></script>

        <!-- Need: Apexcharts -->
        <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
        <script src="assets/static/js/pages/dashboard.js"></script>

        <!-- Page level plugins -->
        <script src="resources/js/chart.js/Chart.min.js"></script>

        <script>
            // Ambil semua elemen dengan kelas sidebar-item
            const sidebarItems = document.querySelectorAll('.sidebar-item');

            // Loop melalui setiap elemen sidebar-item
            sidebarItems.forEach(item => {
                // Tambahkan event listener untuk menangkap saat elemen ditekan
                item.addEventListener('click', function() {
                    // Hapus kelas 'active' dari semua elemen sidebar-item yang ada
                    sidebarItems.forEach(item => {
                        item.classList.remove('active');
                    });

                    // Tambahkan kelas 'active' ke elemen yang ditekan
                    this.classList.add('active');
                });
            });

            // Ambil semua elemen dengan kelas sidebar-item yang memiliki submenu (has-sub)
            const sidebarItemsWithSub = document.querySelectorAll('.sidebar-item.has-sub');

            // Loop melalui setiap elemen sidebar-item yang memiliki submenu (has-sub)
            sidebarItemsWithSub.forEach(item => {
                // Tambahkan event listener untuk menangkap saat elemen ditekan
                item.addEventListener('click', function() {
                    // Hapus kelas 'active' dari semua elemen sidebar-item yang memiliki submenu (has-sub) yang ada
                    sidebarItemsWithSub.forEach(item => {
                        item.classList.remove('active');
                    });

                    // Tambahkan kelas 'active' ke elemen yang ditekan
                    this.classList.add('active');
                });
            });
        </script> --}}

    <!-- Page level custom scripts -->
    {{-- <script src="resources/js/demo/chart-area-demo.js"></script>
        <script src="resources/js/demo/chart-pie-demo.js"></script>
        <script src="resources/js/demo/chart-bar-demo.js"></script> --}}
    @yield('script')
</body>

</html>
