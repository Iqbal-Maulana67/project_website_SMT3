<?php
    require 'config/koneksi.php';
    require('model/history_logs.php');

    session_start();

    if(!isset($_SESSION['username']) || !isset($_SESSION['nama_admin'])){
        header('Location: login.php');
    }
    
    if(isset($_POST['submit_logout'])){
        session_destroy();
        header("Location: login.php");
    }

    if(isset($_POST['submit_accept'])){
        acceptedForm();
    }
    
    if(isset($_POST['submit_denied'])){
        deniedForm();
    }

    function totalAntrian(){
        $koneksi = mysqli_connect('localhost', 'root', '', 'db_sma_darus_sholah');

        $jumlah = 0;
        $sql = "SELECT COUNT('nisn') FROM validasi_status_alumni";
        $result = mysqli_query($koneksi, $sql);
        $row = mysqli_fetch_array($result);
        $jumlah = $row["COUNT('nisn')"];

        return $jumlah;
    }

    function acceptedForm(){
        $koneksi = mysqli_connect('localhost', 'root', '', 'db_sma_darus_sholah');

        $nisn = $_POST['nisn'];
        $status_alumni = $_POST['status_alumni'];
        $nama_instansi = $_POST['nama_instansi'];

        $sql = "UPDATE siswa_alumni SET status_alumni = '$status_alumni', nama_instansi = '$nama_instansi' WHERE nisn = '$nisn'";
        mysqli_query($koneksi, $sql);

        $sql = "SELECT img_pendukung FROM validasi_status_alumni WHERE nisn = '$nisn'";
        $result = mysqli_query($koneksi, $sql);
        $row = $result->fetch_array();

        unlink('../img/validasi_status_images/'.$row['img_pendukung']);

        $sql = "DELETE FROM validasi_status_alumni WHERE nisn = '$nisn'";
        mysqli_query($koneksi, $sql);

        $historyController = new historyLogs();
        $historyController->insertHistory($_SESSION['username'], 'TERIMA PERMINTAAN', $nisn, 'Antrian Validasi Alumni');
        
    }

    function deniedForm(){
        $koneksi = mysqli_connect('localhost', 'root', '', 'db_sma_darus_sholah');

        $nisn = $_POST['nisn'];
        
        $sql = "SELECT img_pendukung FROM validasi_status_alumni WHERE nisn = '$nisn'";
        $result = mysqli_query($koneksi, $sql);
        $row = $result->fetch_array();
        
        unlink('../img/validasi_status_images/'.$row['img_pendukung']);
        
        $sql = "DELETE FROM validasi_status_alumni WHERE nisn = '$nisn'";
        mysqli_query($koneksi, $sql);

        $historyController = new historyLogs();
        $historyController->insertHistory($_SESSION['username'], 'TOLAK PERMINTAAN', $nisn, 'Antrian Validasi Alumni');
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

    <title>Pendasial</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../css/mylogin.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>


            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Data Sekolah
            </div>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Daftar Antrian</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="table_berita.php">
                    <i class="fas fa-fw fa-newspaper"></i>
                    <span>Berita</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTables" aria-expanded="true" aria-controls="collapseTables">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tabel</span>
                </a>
                <div id="collapseTables" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="table_siswa.php">Tabel Siswa</a>
                        <a class="collapse-item" href="table_alumni.php">Tabel Alumni</a>
                    </div>
                </div>
            </li>
            <?php
                if($_SESSION['level_admin'] == "1"){
                    echo '<hr class="sidebar-divider">

                    <div class="sidebar-heading">
                        Owner
                    </div>
        
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdminPages" aria-expanded="true" aria-controls="collapseTables">
                            <i class="fas fa-fw fa-crown"></i>
                            <span>Halaman Owner</span>
                        </a>
                        <div id="collapseAdminPages" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item" href="table_admin.php">Tabel Admin</a>
                                <a class="collapse-item" href="history_page.php">History Perubahan</a>
                            </div>
                        </div>
                    </li>';
                }
            ?>
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
                                    src="../img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
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

                    <h1 class="h3 mb-2 text-gray-800">Antrian Validasi Status Alumni</h1>
                    <div class="row">
                        <!-- Card 1 -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Antrian</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= totalAntrian() ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-person-booth fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DataTable -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-success">Antrian Validasi Status Alumni
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                            </div>

                            <!-- View modal -->


                            <!-- Table Data -->
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>NISN</th>
                                            <th>Nama</th>
                                            <th>Status</th>
                                            <th>Nama Instansi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT vd_alumni.nisn, siswa_alumni.nama, vd_alumni.status_alumni, vd_alumni.nama_instansi, vd_alumni.img_pendukung FROM validasi_status_alumni AS vd_alumni JOIN siswa_alumni ON siswa_alumni.nisn = vd_alumni.nisn";
                                        $result = mysqli_query($koneksi, $sql);

                                        while ($row = $result->fetch_array()) {
                                            echo '
                                                <tr>
                                                    <td>' . $row['nisn'] . '</td>
                                                    <td>' . $row['nama'] . '</td>
                                                    <td>' . $row['status_alumni'] . '</td>
                                                    <td>' . $row['nama_instansi'] . '</td>
                                                    <td style="text-align: center;">    
                                                        <button class="btn btn-warning fas fa-eye" type="button" id="editButton" onclick="viewModal(`' . $row['nisn'] . '`)"></button>
                                                    </td>
                                                </tr>

                                                <div class="modal fade" id="viewModal'.$row['nisn'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Detail Validasi Alumni</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="validation_page.php" method="POST">
                                                                <div class="form-group">
                                                                    <label for="recipient-name" class="col-form-label">NISN</label>
                                                                    <input type="text" class="form-control" id="nisn" name="nisn" value="'.$row['nisn'].'" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="recipient-name" class="col-form-label">Nama Alumni</label>
                                                                    <input type="text" class="form-control" id="nama_alumni" name="nama_alumni" value="'.$row['nama'].'" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="recipient-name" class="col-form-label">Status Alumni</label>
                                                                    <input type="text" class="form-control" id="nama_alumni" name="status_alumni" value="'.$row['status_alumni'].'" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="recipient-name" class="col-form-label">Nama Instansi</label>
                                                                    <input type="text" class="form-control" id="nama_alumni" name="nama_instansi" value="'.$row['nama_instansi'].'" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="recipient-name" class="col-form-label">Gambar</label>
                                                                    
                                                                        <img src="../img/validasi_status_images/'.$row['img_pendukung'].'" alt="" class="berita-img-view">                
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger" name="submit_denied">Tolak Validasi</button>
                                                        <button type="submit" class="btn btn-success" name="submit_accept">Terima Validasi</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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
                <form action="index.php" enctype="multipart/form-data" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Anda yakin keluar dari aplikasi?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success" type="submit" name="submit_logout">Iya</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <!-- <script src="js/demo/datatables-demo.js"></script> -->
    <script>
        var table = $('#dataTable').DataTable();

        $(document).ready(function() {
            // Redraw the table
            table.draw();
        });

        function viewModal(id) {
            var modalName = "#viewModal" + id;
            $(modalName).modal();
        }
    </script>

</body>

</html>