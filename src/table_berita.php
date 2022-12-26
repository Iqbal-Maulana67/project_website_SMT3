<?php
    require 'config/koneksi.php';

    if(isset($_POST['submit_hapus'])){
        hapusBerita();
    }

    function totalData($data){
        $jumlahBerita = 0;
        $koneksi = mysqli_connect('localhost', 'root', '', 'db_sma_darus_sholah');

        if($data == "Berita"){
            $sql = "SELECT COUNT('id_berita') FROM berita";
            $result = mysqli_query($koneksi, $sql);
            $row = mysqli_fetch_array($result);
            $jumlahBerita = $row["COUNT('id_berita')"];
            return $jumlahBerita;
        }

        return $jumlahBerita;
    }

    function hapusBerita(){
        $id_berita = $_POST['submit_hapus'];
        $koneksi = mysqli_connect('localhost', 'root', '', 'db_sma_darus_sholah');

        $sql = "SELECT * FROM berita WHERE id_berita = '$id_berita'";
        $result = mysqli_query($koneksi, $sql);
        $row = $result->fetch_array();
        unlink('../img/berita_image/'.$row['thumbnail_berita']);

        $sql = "DELETE FROM berita WHERE id_berita = '$id_berita'";

        mysqli_query($koneksi, $sql);
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
                <a class="nav-link" href="validation_page.php">    
                    <i class="fas fa-fw fa-list"></i>
                    <span>Daftar Antrian</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
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
            <hr class="sidebar-divider">

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
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php //echo $_SESSION['nama_admin'] ?></span>
                                <img class="img-profile rounded-circle" src="../img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
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

                    <h1 class="h3 mb-2 text-gray-800">Data Berita</h1>
                    <div class="row">
                        <!-- Card 1 -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Berita</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?= totalData("Berita") ?> </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DataTable -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-success">Data Berita</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <a href="tambah_berita_page.php">
                                    <button class="btn btn-success mb-3 text-end m-1" data-toggle="modal" data-target="#insertDataModal">Tambah data</button>
                                </a>
                            </div>

                            <!-- Insert modal -->
                            <div class="modal fade" id="insertDataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">View Berita</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h1 class="h4 mb-2 text-gray-800">
                                            (TITLE)
                                            </h1>
                                            <hr>
                                            <img src="../img/login-background.jpg" alt="" class="berita-img-view">
                                            <p class="berita-description">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Congue mauris rhoncus aenean vel. Dui id ornare arcu odio. Vulputate mi sit amet mauris commodo quis. At auctor urna nunc id cursus metus aliquam eleifend. Vel facilisis volutpat est velit egestas dui id ornare arcu. Cursus eget nunc scelerisque viverra mauris in aliquam. A pellentesque sit amet porttitor eget dolor morbi non. Nunc mi ipsum faucibus vitae aliquet nec. Scelerisque eleifend donec pretium vulputate sapien. Mauris rhoncus aenean vel elit scelerisque.

                                            Vulputate odio ut enim blandit volutpat maecenas volutpat blandit aliquam. Purus semper eget duis at tellus at urna condimentum. Feugiat in fermentum posuere urna nec tincidunt. Ac turpis egestas integer eget. Facilisis magna etiam tempor orci eu lobortis elementum nibh. Tortor dignissim convallis aenean et tortor at. Justo eget magna fermentum iaculis eu non. Sed cras ornare arcu dui. Et tortor at risus viverra adipiscing at in tellus integer. Tortor aliquam nulla facilisi cras fermentum odio eu.
                                            
                                            Orci nulla pellentesque dignissim enim sit amet venenatis urna. Odio ut enim blandit volutpat maecenas volutpat blandit aliquam. Fringilla ut morbi tincidunt augue interdum velit euismod in. Ut sem viverra aliquet eget. Elementum integer enim neque volutpat ac tincidunt vitae semper quis. Nullam eget felis eget nunc lobortis mattis aliquam faucibus. Est pellentesque elit ullamcorper dignissim cras tincidunt. Sem viverra aliquet eget sit amet tellus cras adipiscing enim. Felis donec et odio pellentesque diam. Volutpat sed cras ornare arcu dui vivamus arcu felis. Semper risus in hendrerit gravida rutrum quisque non tellus orci. Accumsan sit amet nulla facilisi morbi tempus iaculis. Vestibulum lorem sed risus ultricies tristique nulla aliquet enim. Aliquam vestibulum morbi blandit cursus risus at ultrices.

                                            Varius quam quisque id diam. Commodo nulla facilisi nullam vehicula ipsum a arcu. Turpis massa sed elementum tempus. Vestibulum morbi blandit cursus risus at. Porta lorem mollis aliquam ut porttitor. Egestas sed sed risus pretium quam. Adipiscing enim eu turpis egestas pretium aenean pharetra magna. Tellus integer feugiat scelerisque varius morbi enim nunc. Est sit amet facilisis magna. Maecenas pharetra convallis posuere morbi leo.

                                            Sem et tortor consequat id porta nibh venenatis cras. Auctor augue mauris augue neque gravida in fermentum. Egestas egestas fringilla phasellus faucibus scelerisque. Lacus luctus accumsan tortor posuere ac ut. Eu augue ut lectus arcu bibendum. Mollis nunc sed id semper risus in hendrerit gravida rutrum. Egestas maecenas pharetra convallis posuere morbi. Condimentum lacinia quis vel eros. Quis vel eros donec ac odio. Varius vel pharetra vel turpis nunc eget lorem. Eu sem integer vitae justo eget magna fermentum iaculis eu. Sem nulla pharetra diam sit amet nisl suscipit. Eget nulla facilisi etiam dignissim diam quis enim lobortis scelerisque. Consectetur lorem donec massa sapien faucibus et molestie. Faucibus interdum posuere lorem ipsum dolor sit amet consectetur.
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hapus Data Modal -->
                            

                            <!-- Table Data -->
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>id_berita</th>
                                            <th>Judul</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $sql = "SELECT * FROM berita";
                                        $result = mysqli_query($koneksi, $sql);

                                        while($row = mysqli_fetch_array($result)){
                                            echo '
                                            <tr>
                                                <td>'. $row['id_berita'] .'</td>
                                                <td>'. $row['judul'] .'</td>
                                                <td style="text-align: center;">
                                                    <button class="btn btn-warning fas fa-sm fa-eye" type="button" id="editButton" onclick="viewModal(`'.$row['id_berita'].'`)"></button>
                                                    <a href="edit_berita_page.php?id_berita='.$row['id_berita'].'"><button class="btn btn-warning fas fa-xs fa-edit" type="button" id="editButton"></button></a>
                                                    <button class="btn btn-danger fas fa-trash-alt" type="button" id="hapusButton" data-toggle="modal" data-target="#hapusTableBerita'.$row['id_berita'].'"></button>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="viewModal'.$row['id_berita'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">View Berita</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h1 class="h4 mb-2 text-gray-800">
                                                        '.$row['judul'].'
                                                        </h1>
                                                        <hr>
                                                        <img src="../img/berita_image/'.$row['thumbnail_berita'].'" alt="" class="berita-img-view">
                                                        <p class="berita-description">
                                                        '.$row['deskripsi'].'
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal" id="hapusTableBerita'.$row['id_berita'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content py-md-5 px-md-4 p-sm-3 p-4" style="border-radius: 20px;">
                                                    <form action="table_berita.php" method="POST">
                                                        <h3>Konfirmasi</h3>
                                                            <p class="r3 px-md-5 px-sm-1">Apa anda yakin menghapus data ini?.</p>
                                                            <div class="text-center mb-3">
                                                            <button type="button" class="btn btn-secondary col-xl-4 col-md-4 col-sm-4" data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger col-xl-4 col-md-4 col-sm-4" name="submit_hapus" value="' . $row['id_berita'] . '">Hapus</button>
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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

        function editModal(id) {
            var modalName = "#editModal" + id;
            $(modalName).modal();
        }
    </script>

</body>
</html>