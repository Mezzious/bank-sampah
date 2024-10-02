<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - User Dashboard</title>

    <link rel="stylesheet" href="./assets/compiled/css/all.view.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="./favicon.ico">

    <!-- Custom fonts for this template-->
    <link href="resources/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="resources/css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="./assets/compiled/css/iconly.css">

    @yield('style')
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>

    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="#"><img src="./assets/compiled/png/kelurahan.png" alt="Logo"
                                    srcset="" style="height: 70px; width: 70px;"></a>
                        </div>
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <div class="form-check form-switch fs-6">
                                <label class="form-check-label"></label>
                            </div>
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i
                                    class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title" style="font-size: 20px;">Menu</li>

                        <li class="sidebar-item active">
                            <a href="{{ route('dashboard_user') }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-basket-fill"></i>
                                <span>Transaksi</span>
                            </a>

                            <ul class="submenu ">

                                <li class="submenu-item  ">
                                    <a href="{{ route('transaksi_beli_user') }}" class="submenu-link"> Transaksi
                                        Beli</a>

                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                                <span>Laporan</span>
                            </a>

                            <ul class="submenu ">

                                <li class="submenu-item  ">
                                    <a href="{{ route('laporan_beli_user') }}" class="submenu-link">Laporan Beli</a>

                                </li>
                            </ul>

                        </li>
                </div>
            </div>

            <div id="main">
                <div class="page-heading">

                </div>
                <header class="mb-3">
                    <a href="#" class="burger-btn d-block d-xl-none">
                        <i class="bi bi-justify fs-3"></i>
                    </a>
                </header>

                <div class="page-content">
                    @yield('content')
                </div>

                <footer class="sticky-footer">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright © KepaEcoBank 2024</span>
                        </div>
                    </div>
                </footer>

            </div>
        </div>

        <script src="assets/static/js/components/dark.js"></script>
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
        </script>

        <!-- Page level custom scripts -->
        <script src="resources/js/demo/chart-area-demo.js"></script>
        <script src="resources/js/demo/chart-pie-demo.js"></script>
        <script src="resources/js/demo/chart-bar-demo.js"></script>
        @yield('script')
</body>

</html>
