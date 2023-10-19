<?php
session_start();
ob_start();
//include "cekuser.php";
include "../fungsi/koneksi.php";

$page = isset($_GET['p']) ? $_GET['p'] : false;
$query = mysqli_query($koneksi, "SELECT COUNT(id_jenis) AS jumlah FROM jenis_barang ");
$data = mysqli_fetch_assoc($query);

/*ini cara sukses redirect ke halaman login untuk mencegah directly url access*/
if(isset($_SESSION['login']) && $_SESSION['login']==true){
    if (isset($_GET['pa'])) {
        if ($_GET['pa'] == 'Dashboard') {
            $dashboard = "active";
            $datauser = "";
            $datastokbarang = "";
            $permintaanbarang = "";
            $pengajuanbarang = "";
            $laporanpermintaanbarang = "";
            $laporanpengajuanbarang = "";
        } else if ($_GET['pa'] == 'DataUser') {
            $dashboard = "";
            $datauser = "active";
            $datastokbarang = "";
            $permintaanbarang = "";
            $pengajuanbarang = "";
            $laporanpermintaanbarang = "";
            $laporanpengajuanbarang = "";
        } else if ($_GET['pa'] == 'DataStokBarang') {
            $dashboard = "";
            $datauser = "";
            $datastokbarang = "active";
            $permintaanbarang = "";
            $pengajuanbarang = "";
            $laporanpermintaanbarang = "";
            $laporanpengajuanbarang = "";

        } else if ($_GET['pa'] == 'PermintaanBarang') {
            $dashboard = "";
            $datauser = "";
            $datastokbarang = "";
            $permintaanbarang = "active";
            $pengajuanbarang = "";
            $laporanpermintaanbarang = "";
            $laporanpengajuanbarang = "";
        }
    }
} else {
    header("Location: https://localhost/sibaper/");
    exit();
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistem Informasi Barang Persediaan</title>
    <link rel="shortcut icon" type="image/icon" href="../gambar/SIBAPER-LOGO-MAROON.png">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link href="../assets/bootstrap/css/custom.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../assets/fa/css/font-awesome.min.css">
    <!-- Ionicons -->
    <!-- Theme style -->
    <link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../assets/dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../assets/plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="../assets/plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="../assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="../assets/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../assets/plugins/daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="../assets/plugins/datatables/dataTables.bootstrap.css">

    <link href="../assets/panel/css/custom.css" rel="stylesheet">
    <!--    <link href="../assets/assets_tambahan/panel/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />-->
    <!--    <link href="../assets/assets_tambahan/panel/css/style.min.css" rel="stylesheet" />-->

    <script src="../assets/plugins/jQuery/jquery.min.js"></script>

</head>
<body class="hold-transition skin-red-light sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <div class="logo" style="background-color: #121619 ">

            <span class="logo-lg"><b>SIBAPER</b></span>
        </div>
        <nav class="navbar navbar-static-top" role="navigation" style="background-color: #21292d">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>


            </a>


        </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <ul class="sidebar-menu">
                <li class="header"><h4
                        class="text-center"><?php if($_SESSION['jabatan']=="Kasub Operator"){
                            echo isset($_SESSION['jabatan'])? "Kasub Pengelola <br> Persediaan Barang" : "Anda Belum Login";
                        }  ?> <br> <span style="font-weight: bold"><?php echo isset($_SESSION['nama_lengkap']) ? ucwords($_SESSION['nama_lengkap']) :"Anda Belum Login" ; ?></span> </h4></li>
                <li class="treeview <?php if (isset($_GET['pa'])){
                    if($_GET['pa']=='Dashboard' || $_GET['pa']=='dashboard'){
                        ?>
                        active
                        <?php
                    }
                } ?>">
                    <a href="index.php?pa=Dashboard" style="<?php if (isset($_GET['pa'])){
                        if($_GET['pa']=='Dashboard' || $_GET['pa']=='dashboard'){
                            ?>
                                background-color: #c7fff1
                            <?php
                        }
                    }  ?>">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <!--                <li class="treeview active" style="">-->
                <!--menu ori yang disembunyikan-->
                <li class="hide treeview <?php if ($_GET['pas'] == 'permintaanbarang' || $_GET['pas'] == 'datapermintaanbarang') { ?> active <?php } ?>">
                    <a href="index.php?pa=PermintaanBarang"
                       style="<?php if ((isset($_GET['pas']) && $_GET['pas'] == 'permintaanbarang') || (isset($_GET['pas']) && $_GET['pas'] == 'datapermintaanbarang')) { ?>background-color: #c7fff1; opacity: 85%<?php } ?>">
                        <i class="fa fa-retweet"></i>
                        <span>Permintaan Barang</span>
                        <span class="pull-right-container">
          <span class="label label-primary pull-right"></span>
        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li style="<?php if ($_GET['pas'] == 'permintaanbarang') { ?> background-color: #89b6a9 <?php } ?>">
                            <a href="index.php?p=datapermintaan&pas=permintaanbarang">
                                <i class="fa fa-circle-o"></i>Permintaan Barang
                            </a>
                        </li>
                    </ul>

                </li>

                <li class="treeview <?php if(isset($_GET['pas'])){
                    if($_GET['pas'] == 'permintaanbarang' || $_GET['pas'] == 'datapermintaanbarang'){
                        ?> active <?php
                    }
                } else if(isset($_GET['p'])){
                    if($_GET['p']=='detilpermintaan_table'){
                        ?> active <?php
                    } else if ($_GET['p']=='alasan_tidak_setuju_kasub_operator_view'){
                        ?> active <?php
                    }
                } ?>">
                    <a href="index.php?pa=PermintaanBarang"
                       style="<?php if ((isset($_GET['pas']) && $_GET['pas'] == 'permintaanbarang') || (isset($_GET['pas']) && $_GET['pas'] == 'datapermintaanbarang')) { ?>
                               background-color: #c7fff1; opacity: 85%;
                       <?php } else if (isset($_GET['p'])){
                            if($_GET['p']=='detilpermintaan_table'){
                                ?> background-color: #c7fff1; opacity: 85%; <?php
                            } else if($_GET['p']=='alasan_tidak_setuju_kasub_operator_view'){
                                ?> background-color: #c7fff1; opacity: 85%; <?php
                            }
                       }?>">
                        <i class="fa fa-retweet"></i>
                        <span>Permintaan Barang <!--Table--></span>
                        <span class="pull-right-container">
          <span class="label label-primary pull-right"></span>
        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li style="<?php if (isset($_GET['pas'])){
                            if($_GET['pas'] == 'permintaanbarang'){
                            ?> background-color: #89b6a9; <?php
                            }
                        } else if(isset($_GET['p'])){
                            if($_GET['p']=='detilpermintaan_table'){
                                ?> background-color: #89b6a9; <?php
                            } else if($_GET['p']=='alasan_tidak_setuju_kasub_operator_view'){
                                ?> background-color: #89b6a9; <?php
                            }
                        } ?>">
                            <a href="index.php?p=datapermintaan_table&pas=permintaanbarang">
                                <i class="fa fa-circle-o"></i>Permintaan Barang <!--Table-->
                            </a>
                        </li>
                    </ul>

                </li>

                <!--ori yang disembunyikan-->
                <li class="hide treeview <?php if($_GET['pa']=='history_kasub_operator') { ?> active <?php }?>">
                    <a href="index.php?p=history_kasub_operator&pa=history_kasub_operator" style="<?php if($_GET['pa']=='history_kasub_operator') { ?>
                            background-color: #c7fff1
                    <?php }?>">
                        <i class="fa fa-sticky-note"></i> <span>History</span>
                    </a>
                </li>
                <li class="treeview <?php if (isset($_GET['pa'])){
                    if($_GET['pa']=='history_kasub_operator'){
                        ?> active <?php
                    }
                } else if (isset($_GET['p'])){
                    if($_GET['p']=='detilpermintaan_history_kasuboperator_table'){
                        ?> active <?php
                    }
                }?>">
                    <a href="index.php?p=history_kasub_operator_table&pa=history_kasub_operator"
                       style="<?php if (isset($_GET['pa'])){
                           if($_GET['pa']=='history_kasub_operator'){
                               ?> background-color: #c7fff1; <?php
                           }
                       } else if (isset($_GET['p'])){
                           if($_GET['p']=='detilpermintaan_history_kasuboperator_table'){
                                ?> background-color: #c7fff1; <?php
                           }
                       }?>">
                        <i class="fa fa-sticky-note"></i> <span>History <!--Table--></span>
                    </a>
                </li>

                <!--metode ubah data user dan metode highlighted menu-->
                <li class="treeview <?php if (isset($_GET['pa'])){
                    if($_GET['pa']=='data_users_kasub_operator'){
                     ?> active <?php
                    }
                } ?>">
                    <a href="index.php?p=data_user_view_kasub_operator&pa=data_users_kasub_operator"
                       style="<?php if (isset($_GET['pa'])){
                            if($_GET['pa']=='data_users_kasub_operator'){
                            ?>
                                    background-color: #c7fff1; opacity: 80%
                                <?php
                            }
                       } ?>">
                        <i class="fa fa-user-circle"></i> <span>Data User</span>
                        <!--                        <span>Data Stok Barang</span>-->

                    </a>
                </li>

                <li><a href="../logout.php"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <?php include "page.php"; ?>
    </div>

    <footer class="main-footer">
        <marquee hspace="40" width="full-width">Kasub Pengelola Persediaan Barang Memberi Persetujuan / Tidak terhadap Permintaan Barang dari Pengelola Persediaan Barang </marquee>
        <!--        <strong>Copyright &copy; Komputerisasi Akuntansi Mercusuar 2020 </strong>-->
    </footer>

    <!-- jQuery UI 1.11.4 -->
    <script src="../assets/plugins/jQueryUI/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->

    <script src="../assets/plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="../assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="../assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="../assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="../assets/plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <!-- datepicker -->
    <script src="../assets/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="../assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="../assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../assets/plugins/fastclick/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/dist/js/app.min.js"></script>

    <script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/plugins/datatables/dataTables.bootstrap.min.js"></script>

    <script type="text/javascript">
        function back() {
            window.history.forward();
        }

        // Force Client to forward to last (current) Page.
        setTimeout("back()", 0);

        window.onunload = function () {
            null
        };
    </script>

</body>
</html>
