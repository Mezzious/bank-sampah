<?php
// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'kepaecobank';

$conn = mysqli_connect($host, $username, $password, $database);

// Mendapatkan tanggal awal dan tanggal akhir dari URL
$tglAwal = $_GET['tglAwal'];
$tglAkhir = $_GET['tglAkhir'];

// Query untuk mengambil data laporan berdasarkan tanggal
$query = "SELECT * FROM table_laporan_beli WHERE tanggal_beli BETWEEN '$tglAwal' AND '$tglAkhir'";
$result = mysqli_query($conn, $query);

// Header untuk membuat file PDF
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="laporan_beli.pdf"');

// Membuat objek PDF menggunakan library seperti TCPDF, FPDF, dll.
// Contoh menggunakan TCPDF
require_once('tcpdf/tcpdf.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Laporan Transaksi Pembelian');
$pdf->SetHeaderData('', '', 'Laporan Transaksi Pembelian', '');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

// Membuat tabel untuk menampilkan data laporan
$content = '<table border="1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Beli</th>
                        <th>RW</th>
                        <th>Jenis Sampah</th>
                        <th>Banyak</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>';

$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $content .= '<tr>
                    <td>' . $no++ . '</td>
                    <td>' . $row['tanggal_beli'] . '</td>
                    <td>' . $row['rw'] . '</td>
                    <td>' . $row['jenis_sampah'] . '</td>
                    <td>' . $row['banyak'] . '</td>
                    <td>' . $row['harga_satuan'] . '</td>
                    <td>' . $row['total'] . '</td>
                </tr>';
}

$content .= '</tbody></table>';

$pdf->writeHTML($content, true, false, true, false, '');

$pdf->Output('laporan_beli.pdf', 'I');

?>
