@extends('app')

@section('content')

<h2 class="active" style="font-size: 30px;">Data Administrator</h2>
<br>

  <style>
/* CSS untuk Tata Letak Responsif Mobile */

/* Atur lebar maksimum untuk konten */
.container {
    max-width: 100%; /* Konten akan mengisi lebar layar penuh */
    margin: 0 auto; /* Posisi tengah */
    padding: 0 20px; /* Ruang padding di sisi kanan dan kiri */
}

/* Tata letak responsif untuk baris */
.row {
    display: flex; /* Mengubah tata letak menjadi flexbox */
    flex-wrap: wrap; /* Baris akan menggulung ke baris baru saat tidak cukup ruang */
    margin: 0 -10px; /* Ruang negatif untuk kompensasi padding kolom */
}

/* Atur lebar kolom pada layar kecil */
.col {
    flex: 0 0 100%; /* Setiap kolom akan menempati lebar 100% pada layar kecil */
    padding: 0 10px; /* Ruang padding di sisi kanan dan kiri */
}

/* Atur ulang tata letak untuk mode mobile */
@media (max-width: 576px) {
    .row {
        flex-direction: column; /* Menata elemen dalam satu kolom pada mode mobile */
    }
    
    .col {
        flex: 1 0 100%; /* Setiap kolom akan menempati lebar 100% pada mode mobile */
        padding: 0; /* Menghapus padding untuk memaksimalkan ruang */
    }

    .search-bar {
        order: -1; /* Memindahkan elemen "Search" ke atas */
        margin-bottom: 10px; /* Memberikan ruang antara elemen */
    }

    .entries-container {
        text-align: left; /* Atur ulang posisi "Show Entries" ke kiri */
    }
}


table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  border: 1px solid; /* warna awal garis */
  padding: 8px;
}

th {
  text-align: left;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}

.search-bar {
  width: 200px;
  padding: 5px;
  margin-bottom: 10px;
}

.pagination {
  text-align: center;
}

.pagination a {
  padding: 5px;
  border: 1px solid #ddd;
  margin-right: 5px;
}

.pagination a:hover {
  background-color: #ddd;
}

.pagination a.active {
  background-color: #000;
  color: #fff;
}

.btn-container {
            text-align: right;
            margin-left: auto; /* Posisikan ke kanan */
        }
        #search {
    margin-bottom: 5px;
    float: right;
        }

    #search input {
    width: 300px;
}
.row {
    width: 100%;
}
  </style>

<div class="mb-3"></div>
<div class="row">
<div class="col">
    <div class="card shadow">
        <div class="card-body">

            <div class="row">
                <div class="d-flex justify-content-between">
                  <!-- Bagian "Show Entries" di kiri -->
                  <div class="entries-container">
                    <label for="entries">Show Entries:</label>
                    <select id="entries" onchange="changeEntries()">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                  </div>
                  <!-- Bagian "Search" di kanan -->
                  <div>
                    <label for="search">Search:</label>
                    <input type="text" id="search" name="search" placeholder="Type your search query..." />
                  </div>
                </div>
              </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-secondary">
                        <tr>
                            <th>No</th>
                            <th>Id_User</th>
                            <th>Nama Admin</th>
                            <th>Nomor Telepon</th>
                            <th>E-mail</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td>1</td>
                                <td>123</td>
                                <td>John Doe</td>
                                <td>123-456-7890</td>
                                <td>john.doe@example.com</td>
                                <td>Admin</td>
                                <td> <a href="#" class="btn btn-warning btn-sm"> <i class="fas fa-edit"></i> </a>
                                    <a href="#" class="btn btn-danger btn-sm"> <i class="fas fa-trash"></i> </a>
                                    </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>456</td>
                                <td>Jane Doe</td>
                                <td>987-654-3210</td>
                                <td>jane.doe@example.com</td>
                                <td>User</td>
                    <td> <a href="#" class="btn btn-warning btn-sm"> <i class="fas fa-edit"></i> </a>
                    <a href="#" class="btn btn-danger btn-sm"> <i class="fas fa-trash"></i> </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="row" >
            <div class="d-flex justify-content-between">
            <div>
            <a href="#">
            <button><i class="fa fa-plus" aria-hidden="true"></i>Tambah</button>
            </a>
        </div>
        <div>
            <div class="btn-container">
                <button class="btn btn-previous">Previous</button>
                <button><a class="paginate_button current" aria-controls="example" data-dt-idx="1" tabindex="0">1</a></button>
                <button class="btn btn-next">Next</button>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection

