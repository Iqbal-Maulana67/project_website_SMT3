<?php
require('koneksi.php');

session_start();


if(!isset($_SESSION['username']) || !isset($_SESSION['nama_admin'])){
    header('Location: login.php');
}

if(isset($_POST['submit_insert'])){
    insertDataSiswa();
}

// Menampilkan jumlah siswa untuk card body
function tampilSiswa($siswaArgs){
    $koneksi = mysqli_connect('localhost','root','','db_sma_darus_sholah');
    if($siswaArgs == 'all'){
        $jumlahSiswa = 0;
        $query = "SELECT COUNT('NISN') FROM siswa_aktif";
        $result = mysqli_query($koneksi, $query);
        $row = mysqli_fetch_array($result);
        $jumlahSiswa = $row["COUNT('NISN')"];
        return $jumlahSiswa;
    }else if($siswaArgs == 'X'){
        $jumlahSiswa = 0;
        $query = "SELECT COUNT('NISN') FROM siswa_aktif WHERE kelas = 'X'";
        $result = mysqli_query($koneksi, $query);
        $row = mysqli_fetch_array($result);
        $jumlahSiswa = $row["COUNT('NISN')"];
        return $jumlahSiswa;
    }else if($siswaArgs == 'XI'){
        $jumlahSiswa = 0;
        $query = "SELECT COUNT('NISN') FROM siswa_aktif WHERE kelas = 'XI'";
        $result = mysqli_query($koneksi, $query);
        $row = mysqli_fetch_array($result);
        $jumlahSiswa = $row["COUNT('NISN')"];
        return $jumlahSiswa;
    }else if($siswaArgs == 'XII'){
        $jumlahSiswa = 0;
        $query = "SELECT COUNT('NISN') FROM siswa_aktif WHERE kelas = 'XII'";
        $result = mysqli_query($koneksi, $query);
        $row = mysqli_fetch_array($result);
        $jumlahSiswa = $row["COUNT('NISN')"];
        return $jumlahSiswa;
    }
}

function insertDataSiswa(){
    $koneksi = mysqli_connect('localhost','root','','db_sma_darus_sholah');

    $nisn = $_POST['nisn'];
    $nama = $_POST['nama_siswa'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $kelas = $_POST['kelas'];
    $golongan = $_POST['golongan'];
    $jurusan = fetchCariJurusan($_POST['jurusan']);
    $nama_ortu = $_POST['nama_ortu'];
    $alamat = $_POST['alamat'];

    $sql = mysqli_query($koneksi, 
    "INSERT INTO siswa_aktif  (nisn, nama_siswa, jenis_kelamin, alamat, nama_ortu, kelas, id_jurusan, golongan)
    VALUES ('$nisn', '$nama', '$jenis_kelamin', '$alamat', '$nama_ortu','$kelas','".$jurusan['id_jurusan']."','$golongan')");
}

function fetchDataJurusan(){
    $koneksi = mysqli_connect('localhost','root','','db_sma_darus_sholah');
    $query = "SELECT * FROM jurusan";
    $result = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($result)){
        echo '<option value="'.$row['nama_jurusan'].'">'.$row['nama_jurusan'].'</option>';
    }
}

function fetchCariJurusan($nama_jurusan){
    $koneksi = mysqli_connect('localhost','root','','db_sma_darus_sholah');
    $query = "SELECT * FROM jurusan WHERE nama_jurusan = '$nama_jurusan'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_array($result);

    return $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Tables</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    
                </div>
                <div class="sidebar-brand-text mx-3">SMA Darus Sholah</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>


            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Data Sekolah
            </div>

            <li class="nav-item">
                <a class ="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTables"
                aria-expanded="true" aria-controls="collapseTables">
                    <i class = "fas fa-fw fa-table"></i>
                    <span>Tabel</span>
                </a>
                <div id="collapseTables" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="">Tabel Siswa</a>
                        <a class="collapse-item" href="">Tabel Alumni</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Admin
            </div>

            <li class="nav-item">
                <a class ="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdminPages"
                aria-expanded="true" aria-controls="collapseTables">
                    <i class = "fas fa-fw fa-table"></i>
                    <span>Halaman Owner</span>
                </a>
                <div id="collapseAdminPages" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="">Tabel Admin</a>
                        <a class="collapse-item" href="">History Perubahan</a>
                    </div>
                </div>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?=$_SESSION['nama_admin']?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    
                <h1 class="h3 mb-2 text-gray-800">Data Siswa Aktif</h1>
                <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Siswa Aktif</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?=tampilSiswa('all')?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Siswa Kelas X</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?=tampilSiswa('X')?></div>
                                </div>
                                <div class="col-auto">      
                                    <i class="fas fa-user fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Siswa Kelas XI</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?=tampilSiswa('XI')?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Siswa Kelas XII</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?=tampilSiswa('XII')?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-success">Tabel Siswa Aktif</h6>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-success mb-3 text-end" data-toggle="modal" data-target="#exampleModalLong">Tambah data</button>
                            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data Siswa</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <form action="table_siswa.php" method="POST">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">NISN</label>
                                            <input type="text" class="form-control" id="nisn" name="nisn">
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Nama Siswa</label>
                                            <input type="text" class="form-control" id="nama_siswa" name="nama_siswa">
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Jenis Kelamin</label>
                                            <select class="custom-select" id="jenis_kelamin" name="jenis_kelamin">
                                                <option selected>Jenis Kelamin</option>
                                                <option value="L">Laki-laki</option>
                                                <option value="P">Perempuan</option>                    
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Kelas</label>
                                            <select class="custom-select" id="kelas" name="kelas">
                                                <option selected>Kelas</option>
                                                <option value="X">X</option>
                                                <option value="XI">XI</option>
                                                <option value="XII">XII</option>                    
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Golongan</label>
                                            <select class="custom-select" id="golongan" name="golongan">
                                                <option selected>Golongan</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>                    
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Jurusan</label>
                                            <select class="custom-select" id="jurusan" name="jurusan">
                                                <option selected>Jurusan</option>
                                                <?php
                                                    fetchDataJurusan();
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Nama Orang Tua</label>
                                            <input type="text" class="form-control" id="nama_ortu" name="nama_ortu">
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat"></textarea>
                                        </div> 
                                        <div class="form-group">
                                        </div>
                                    
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success" name="submit_insert">Masukkan Data</button>
                                  </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>NISN</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Kelas</th>
                                            <th>Golongan</th>
                                            <th>Jurusan</th>
                                            <th>Nama Orang Tua</th>
                                            <th>Alamat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php
                                            $query = "SELECT * FROM siswa_aktif JOIN jurusan ON siswa_aktif.id_jurusan = jurusan.id_jurusan";
                                            $result = mysqli_query($koneksi, $query);
                                            $numrows = mysqli_num_rows($result);

                                            while($row = mysqli_fetch_array($result)){
                                                echo '
                                                <tr>
                                                    <td>'.$row['nisn'].'</td>
                                                    <td>'.$row['nama_siswa'].'</td>
                                                    <td>'.$row['jenis_kelamin'].'</td>
                                                    <td>'.$row['kelas'].'</td>
                                                    <td>'.$row['golongan'].'</td>
                                                    <td>'.$row['nama_jurusan'].'</td>
                                                    <td>'.$row['nama_ortu'].'</td>
                                                    <td>'.$row['alamat'].'</td>
                                                    <td>
                                                        <button class="btn btn-success fas fa-edit" onclick="takeData()" type="button"></button>
                                                        <a href="" class="btn btn-danger fas fa-trash-alt"></a>
                                                    </td>
                                                </tr>
                                                ';
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <!-- <script src="js/demo/datatables-demo.js"></script> -->
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                // initComplete: function () {
                //     this.api()
                //         .columns()
                //         .every(function () {
                //             var column = this;
                //             var select = $('<select><option value=""></option></select>')
                //                 .appendTo($(column.footer()).empty())
                //                 .on('change', function () {
                //                     var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                
                //                     column.search(val ? '^' + val + '$' : '', true, false).draw();
                //                 });
                            
                //             column
                //                 .data()
                //                 .unique()
                //                 .sort()
                //                 .each(function (d, j) {
                //                     select.append('<option value="' + d + '">' + d + '</option>');
                //                 });
                //         });
                // },
            });
        });
    </script>

</body>

</html>