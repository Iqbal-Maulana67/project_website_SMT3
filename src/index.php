<?php
    require('config/koneksi.php');

    session_start();

    if(!isset($_SESSION['username']) || !isset($_SESSION['nama_admin'])){
        header('Location: login.php');
    }
    
    if(isset($_POST['submit_logout'])){
        session_destroy();
        header("Location: login.php");
    }

    function getCountedData($args){
        $koneksi = mysqli_connect('localhost', 'root', '', 'db_sma_darus_sholah');
        $totalJumlah = 0;
        if($args == "AKTIF"){
            $sql = "SELECT COUNT(nisn) FROM siswa_aktif";
            $result = mysqli_query($koneksi, $sql);
            $row = mysqli_fetch_array($result);
            $totalJumlah = $row['COUNT(nisn)'];
        } else if($args == "KULIAH"){
            $sql = "SELECT COUNT(nisn) FROM siswa_alumni WHERE status_alumni = 'Kuliah'";
            $result = mysqli_query($koneksi, $sql);
            $row = mysqli_fetch_array($result);
            $totalJumlah = $row['COUNT(nisn)'];
        } else if($args == "KERJA"){
            $sql = "SELECT COUNT(nisn) FROM siswa_alumni WHERE status_alumni = 'Kerja'";
            $result = mysqli_query($koneksi, $sql);
            $row = mysqli_fetch_array($result);
            $totalJumlah = $row['COUNT(nisn)'];
        } else if($args == "VALIDASI"){
            $sql = "SELECT COUNT(nisn) FROM validasi_status_alumni";
            $result = mysqli_query($koneksi, $sql);
            $row = mysqli_fetch_array($result);
            $totalJumlah = $row['COUNT(nisn)'];
        }
        return $totalJumlah;
    }

    function getDataStatistic($args){
        $koneksi = mysqli_connect('localhost', 'root', '', 'db_sma_darus_sholah');
        $sql = "";
        if($args == "KERJA"){
            $sql = "SELECT tahun_lulusan, COUNT(nisn) FROM siswa_alumni WHERE status_alumni= 'Kerja' GROUP BY tahun_lulusan";
        }else if($args == "KULIAH"){
            $sql = "SELECT tahun_lulusan, COUNT(nisn) FROM siswa_alumni WHERE status_alumni='Kuliah' GROUP BY tahun_lulusan";
        }

        return mysqli_query($koneksi, $sql);
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

    <title>Pendasial - Dashboard</title>

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
                <a class="nav-link" href="">
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

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- TOTAL SISWA AKTIF -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Siswa Aktif</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= getCountedData("AKTIF") ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TOTAL ALUMNI KULIAH -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Alumni Kuliah</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= getCountedData("KULIAH") ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TOTAL ALUMNI KERJA -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Alumni Kerja</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= getCountedData("KERJA") ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TOTAL ADMIN -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Antrian Validasi Status Alumni</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= getCountedData("VALIDASI") ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-success">Statistik Alumni</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="dashboardChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->Owne

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Pendasial SMA Darus Sholah</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

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
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-area-dashboard.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>

    <?php
        $sql = "SELECT DISTINCT tahun_lulusan FROM siswa_alumni ORDER BY tahun_lulusan ASC";
        $result = mysqli_query($koneksi, $sql);
    ?>

    <script>
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        var ctx = document.getElementById("dashboardChart");
        var LineChart2 = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                    <?php while ($row = mysqli_fetch_array($result)) {
                        echo '"' . $row['tahun_lulusan'] . '",';
                    }
                    ?>],
            datasets: [
            {
            label: "Total Alumni Bekerja",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "rgba(78, 115, 223, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(78, 115, 223, 1)",
            pointBorderColor: "rgba(78, 115, 223, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: [
                <?php 
                     $result = getDataStatistic("KERJA");
                     while($row = mysqli_fetch_array($result)){
                         echo $row['COUNT(nisn)'].',';
                     }
                ?>
                ],
            },
            {
            label: "Total Alumni Kuliah",
            lineTension: 0.3,
            backgroundColor: "rgba(39, 186, 9, 0.05)",
            borderColor: "rgba(39, 186, 9, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(39, 186, 9, 1)",
            pointBorderColor: "rgba(39, 186, 9, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(39, 186, 9, 1)",
            pointHoverBorderColor: "rgba(39, 186, 9, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: [
                <?php 
                    $result = getDataStatistic("KULIAH");
                    while($row = mysqli_fetch_array($result)){
                        echo $row['COUNT(nisn)'].',';
                    }
                ?>
            ],
            }
        ],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
            },
            scales: {
            xAxes: [{
                time: {
                unit: 'date'
                },
                gridLines: {
                display: false,
                drawBorder: false
                },
                ticks: {
                maxTicksLimit: 7
                }
            }],
            yAxes: [{
                ticks: {
                maxTicksLimit: 5,
                padding: 10,
                // Include a dollar sign in the ticks
                callback: function(value, index, values) {
                    return number_format(value);
                }
                },
                gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
                }
            }],
            },
            legend: {
            display: false
            },
            tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, chart) {
                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                return datasetLabel + ": " + tooltipItem.yLabel;
                }
            }
            }
        }
        });
    </script>

</body>

</html>