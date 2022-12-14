<?php

use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Counts;

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

    if(isset($_POST['submit_insert'])){
        InsertData();
    }

    function InsertData(){
        $koneksi = mysqli_connect('localhost', 'root', '', 'db_sma_darus_sholah');

        $id_berita = $_POST['id_berita'];
        $judul = $_POST['judul']; 
        $deskripsi = $_POST['deskripsi_berita'];
        $date = date("Y-m-d");
        
        $ext_file = pathinfo($_FILES['namafile']['name'], PATHINFO_EXTENSION);
        $nama_file_baru = 'image_berita_'.$id_berita.'.'.$ext_file;

        if(is_file('../img/berita_image/'.$nama_file_baru)) unlink('../img/berita_image/'.$nama_file_baru);

        $tmp_file = $_FILES['namafile']['tmp_name'];
        $file_size = $_FILES['namafile']['size'];
        $maximumFileSize = 2097152;
        
        if($file_size <= $maximumFileSize){
            if($ext_file == "jpg" || $ext_file == "jpeg" || $ext_file == "png"){
                $sql = "INSERT INTO berita (id_berita, judul, thumbnail_berita, tanggal_berita, deskripsi)
                VALUES ('$id_berita', '$judul', '$nama_file_baru', '$date', '$deskripsi')";
                echo $sql;
                mysqli_query($koneksi, $sql);       
    
                move_uploaded_file($tmp_file, '../img/berita_image/'.$nama_file_baru);
                // header('Location: table_berita.php?');
                $historyController = new historyLogs();
                $historyController->insertHistory($_SESSION['username'], 'TAMBAH', $id_berita, 'Data Berita');
            }
        }else{
            echo "<script type='text/javascript'>alert('Ukuran file terlalu besar!');</script>";
        }
    }

    function countGenerator($numb){
        $numb++;
        if(strlen($numb) > 2){
            return $numb;
        }else if(strlen($numb) > 1){
            $numb = "0".$numb;
            return $numb;
        }else if(strlen($numb) > 0){
            $numb = "00".$numb;
            return $numb;
        }
    }

    function idBeritaGenerator(){
        $koneksi = mysqli_connect('localhost', 'root', '', 'db_sma_darus_sholah');
        
        $date = date("d");
        $month = date("m");
        $year = substr(date("Y"), 2);

        $sql = "SELECT id_berita FROM berita WHERE id_berita LIKE 'BRT$date$month$year%' ORDER BY id_berita DESC";
        $result = mysqli_query($koneksi, $sql);
        if($row = $result->fetch_array()){
            $countIDs = substr($row['id_berita'], 9);
            $newIDs = "BRT$date$month$year".countGenerator($countIDs);
            return $newIDs;
        }else{
            $newIDs = "BRT$date$month$year"."001";
            return $newIDs;
        }
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
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

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
                <a class="nav-link" href="validation_page.php">    
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
                    
                    <h1 class="h3 mb-2 text-gray-800">
                    <a href="table_berita.php"><i class="fas fa-arrow-left text-black-50"></i></a>        
                    Tambah Data Berita
                    </h1>
                    <hr>
                    <form action="tambah_berita_page.php" method="post" enctype="multipart/form-data">
                            <input type="text" class="form-control" id="id_berita" name="id_berita" value="<?= idBeritaGenerator() ?>" hidden>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Judul Berita</label>
                            <input type="text" class="form-control" id="judul_berita" name="judul" required>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Thumbnail Berita</label><br>
                            <input name="namafile" type="file" required="required">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Deskripsi Berita</label>
                            <textarea class="form-control" id="alamat" name="deskripsi_berita" style="height: 10rem;" required></textarea>
                        </div>
                        <hr>
                        <div class="form-group" >
                            <a href="table_berita.php"><button type="button" class="btn btn-secondary">Batal</button></a>
                            <button type="submit" class="btn btn-success" name="submit_insert">Tambahkan Berita</button>
                        </div>
                    </form>
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
                        <span aria-hidden="true">??</span>
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

        function edit(nisn) {
            var modalName = "#editTable" + nisn;
            $(modalName).modal();
        }
    </script>

</body>
</html>