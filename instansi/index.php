

<?php


session_start();
//include "../fungsi/ceklogin.php";

include "../fungsi/koneksi.php";

//ditambah johan untuk mencegah direct url access
//if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
//    header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
//    die ("<h2>Access Denied!</h2> This file is protected and not available to public.");
//}

$page = isset($_GET['p']) ? $_GET['p'] : false;
//include 'cekuser.php';
$query = mysqli_query($koneksi, "SELECT COUNT(id_jenis) AS jumlah FROM jenis_barang ");
$data = mysqli_fetch_assoc($query);

$query_get_pengambilan_barang_old = mysqli_query($koneksi,"select count(id_sementara) as jml_pengambilan 
from sementara where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and status_acc in('Penyerahan Barang Ke Pengguna')");

$data_pengambilan_barang_old = mysqli_fetch_assoc($query_get_pengambilan_barang_old);

$query_get_pengambilan_barang = mysqli_query($koneksi,"select * 
from sementara where unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and 
status_acc in('Penyerahan Barang Ke Pengguna') group by
user_id");

$data_pengambilan_barang = mysqli_num_rows($query_get_pengambilan_barang);

/*ini cara sukses redirect ke halaman login untuk mencegah directly url access*/
if(isset($_SESSION['login']) && $_SESSION['login']==true){
    if(isset($_GET['pa'])){
        if($_GET['pa']=='Dashboard' ){
            $dashboard = "active";
            $databarang = "";
            $datapermintaan = "";
            $cetakbpp = "";


        } else if($_GET['pa']=="DataBarang"){
            $dashboard = "";
            $databarang = "active";
            $datapermintaan = "";
            $cetakbpp = "";


            if(isset($_GET['pas'])){
                if($_GET['pas']=="atk"){
                    $atk ="active";
                    $kebersihan ="";
                    $perlengkapan ="";

                    $dashboard = "";
                    $databarang = "";
                    $datapermintaan = "";
                    $cetakbpp = "";
                }
            }

        } else if($_GET['pa']=="Permintaan"){
            $dashboard = "";
            $databarang = "";
            $datapermintaan = "active";
            $cetakbpp = "";

        } else if($_GET['pa']=="Cetak"){
            $dashboard = "";
            $databarang = "";
            $datapermintaan = "";
            $cetakbpp = "active";

        }
    } else {
        $dashboard = "";
        $databarang = "";
        $datapermintaan = "";
        $cetakbpp = "";


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
<!--    <link rel="shortcut icon" type="image/icon" href="gambar/SIMANTAB1.png">-->
<!--    <img src="gambar/SIMANTAB1.png" style="width: 10px; height: 15px; border-radius: 20%">-->
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

    <!--tambah disini untuk metode tabel responsive-->
    <link rel="stylesheet" href="../assets/plugins/datatables/dataTables.bootstrap.css">

    <script src="../assets/plugins/jQuery/jquery.min.js"></script>

    <!--Ditambah Johan :-->
    <!--Script mencegah button kembali/back-->
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

</head>
<body class="hold-transition skin-red-light sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <div class="logo" style="background-color: #121619">
            <span class="logo-lg"><b>SIBAPER</b></span>
        </div>

        <nav class="navbar navbar-static-top" style="background-color: #21292d" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
        </nav>

    </header>
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu">
                <li class="header"><h4 class="text-center"><?php echo isset($_SESSION['jabatan'])? strtoupper($_SESSION['jabatan']):"Anda Belum Login"; ?><br>
                        <span style="font-weight: bold"><?php echo isset($_SESSION['nama_lengkap'])? ucwords($_SESSION['nama_lengkap']):"Anda Belum Login"; ?></span></h4></li>
                <li class="<?= $dashboard; ?> treeview">
                    <!--          <li><a href="index.php?p=cetakpesanan"><i class="fa fa-print"></i> Cetak BPP</a></li>-->
                    <a href="index.php?pa=Dashboard"
                       style="<?php if($dashboard=="active"){?> background-color: #c7fff1; opacity: 80% <?php } ?>">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <!--metode Data Stok Barang sisi Pengguna / Instansi Di-sembunyikan-->
                <li class="hide treeview <?php if($_GET['pas']=='atk' || $_GET['pas']=='kebersihan' || $_GET['pas']=='perlengkapan') { ?> active <?php } ?>" >
                    <!--          <a href="#">-->
                    <a href="index.php?pa=DataBarang"
                       style="<?php if(isset($_GET['pas'])) { ?>background-color: #c7fff1; opacity: 85%<?php } ?>">
                        <i class="fa fa-table"></i>
                        <span>Data Stok Barang</span>
                        <span class="pull-right-container">
              <span class="label label-primary pull-right"><?= $data['jumlah'];?></span>
            </span>
                    </a>
                    <ul class="treeview-menu" data-collapse="true">
                        <li style="<?php if($_GET['pas']=='atk') { ?> background-color: #87b2a4 <?php } ?>" class=" treeview">
                            <a href="index.php?p=material&id_jenis=1&pas=atk" >
                                <i class="fa fa-circle-o"></i>ATK
                            </a>
                        </li>
                        <li style="<?php if($_GET['pas']=='kebersihan') { ?> background-color: #87b2a4 <?php } ?>" class="">
                            <a href="index.php?p=material&id_jenis=2&pas=kebersihan" >
                                <i class="fa fa-circle-o"></i>ALAT KEBERSIHAN
                            </a>
                        </li>
                        <li style="<?php if($_GET['pas']=='perlengkapan') { ?> background-color: #87b2a4 <?php } ?>" class="">
                            <a href="index.php?p=material&id_jenis=3&pas=perlengkapan" >
                                <i class="fa fa-circle-o"></i>PERLENGKAPAN LAINNYA
                            </a>
                        </li>
                    </ul>
                </li>

                <!--disembunyikan-->
                <li class="hide <?= $datapermintaan; ?>">
                    <a href="index.php?p=datapesanan&pa=Permintaan"
                       style="<?php if($datapermintaan=="active"){?> background-color: #c7fff1; opacity: 80% <?php }?>">
                        <i class="fa fa-files-o"></i> Data Permintaan Barang
                    </a>
                </li>
                <li class="<?= $datapermintaan; ?>">
                    <a href="index.php?p=datapesanan_table&pa=Permintaan"
                       style="<?php if (isset($_GET['p'])){
                           if($_GET['p']=='datapesanan_table'){
                            ?>
                                   background-color: #c7fff1; opacity: 80%; font-weight: bold;
                               <?php
                           } else if ($_GET['p']=='formpesan_table'){
                                ?>
                                   background-color: #c7fff1; opacity: 80%; font-weight: bold;
                               <?php
                           } else if ($_GET['p']=='detil_table'){
                                ?>
                                   background-color: #c7fff1; opacity: 80%; font-weight: bold;
                               <?php
                           }
                       } ?>">
                        <i class="fa fa-files-o"></i> Data Permintaan Barang <!--Table-->
                    </a>
                </li>

                <!--PR Disini-->
                <!--disembunyikan-->
                <li class="hide treeview <?php if($_GET['pa']=='history_pengguna') { ?> active <?php } ?>">
                    <a href="index.php?p=history_permintaan_barang&pa=history_pengguna"
                       style="<?php if($_GET['pa']=='history_pengguna') {?> background-color: #c7fff1; opacity: 80% <?php } ?>">
                        <i class="fa fa-sticky-note-o"></i> <span>History</span>
<!--                        <span>Data Stok Barang</span>-->
                        <span class="pull-right-container">
                            <?php if (($data_pengambilan_barang)>0){ ?>
                                <span class="label label-danger pull-right">
                                    <?= $data_pengambilan_barang;?>
                                </span>
                            <?php } ?>

            </span>
                    </a>
                </li>

<!--                <li class="treeview --><?php //if($_GET['pa']=='history_pengguna') { ?><!-- active --><?php //} ?><!--">-->
                <li class="treeview <?php if(isset($_GET['pa'])){
                    if($_GET['pa']=='history_pengguna'){
                        ?> active <?php
                    }
                }  ?>">
                    <?php $sekarang=date('Y-m-d');?>
                    <a href="index.php?p=history_permintaan_barang_table&pa=history_pengguna"
                       style="<?php if(isset($_GET['pa'])){
                           if($_GET['pa']=='history_pengguna'){
                               ?> background-color: #c7fff1; opacity: 80%; font-weight: bold; <?php
                           }
                       } else if (isset($_GET['p'])){
                           if($_GET['p']=='detil_history_permintaan_barang_table'){
                               ?>
                                   background-color: #c7fff1; opacity: 80%; font-weight: bold;
                               <?php
                           }
                       } ?>">
                        <!--index.php?p=history_permintaan_barang_table&pa=history_pengguna-->
                        <i class="fa fa-sticky-note-o"></i> <span>History <!--Table--></span>
<!--                        <span>Data Stok Barang</span>-->
                        <span class="pull-right-container">
                            <?php if (($data_pengambilan_barang)>0){ ?>
                                <span class="label label-danger pull-right">
                                    <?= $data_pengambilan_barang;?>
                                </span>
                            <?php } ?>

            </span>
                    </a>
                </li>
                <li class="hide" >
                    <a href="index.php?p=cetakpesanan&pa=Cetak"
                       style="">
                        <i class="fa fa-print"></i> Cetak BPP ori
                    </a>
                </li>

                <!--Disembunyikan-->
                <li class="hide <?= $cetakbpp; ?>" >
                    <a href="index.php?p=cetak_bpp_baru&pa=Cetak"
                       style="<?php if($cetakbpp=="active"){?> background-color: #c7fff1; opacity: 80% <?php }?>">
                        <i class="fa fa-print"></i> Cetak BPP
                    </a>
                </li>

                <!--Disembunyikan-->
                <li class="hide <?= $cetakbpp; ?>" >
                    <a href="index.php?p=cetak_bpp_baru_table&pa=Cetak"
                       style="<?php if($cetakbpp=="active"){?> background-color: #c7fff1; opacity: 80% <?php }?>">
                        <i class="fa fa-print"></i> Cetak BPP Table
                    </a>
                </li>
                <li class="<?= $cetakbpp; ?>" >
                    <a href="index.php?p=cetak_bpp_baru_table_v2&pa=Cetak"
                       style="<?php if($cetakbpp=="active"){?> background-color: #c7fff1; opacity: 80% <?php }?>">
                        <i class="fa fa-print"></i> Cetak BPP <!--Table V2-->
                    </a>
                </li>

                <!--metode ubah data user-->
<!--                <li class="treeview --><?php //if($_GET['pa']=='data_users') { ?><!-- active --><?php //} ?><!--">-->
                <li class="treeview <?php if(isset($_GET['pa'])){
                    if($_GET['pa']=='data_users'){
                        ?> active <?php
                    }
                }?>">
                    <a href="index.php?p=data_user_view&pa=data_users"
                       style="<?php if(isset($_GET['pa'])){
                           if($_GET['pa']=='data_users'){
                               ?> background-color: #c7fff1; opacity: 80% <?php
                           }
                       } ?>">
                        <i class="fa fa-user-circle"></i> <span>Data User</span>
                        <!--                        <span>Data Stok Barang</span>-->

                    </a>
                </li>
                <li><a href="../logout.php">
                        <i class="fa fa-sign-out"></i>
                        <span>Logout</span>
                    </a>
                </li>

            </ul>
        </section>
    </aside>
    <div class="content-wrapper">
        <?php
        include "page.php";
        ?>
    </div>

    <footer class="main-footer">
        <marquee hspace="40" width="full-width">Setelah permintaan di konfirmasi oleh Pengelola Persediaan Barang, Pemohon Brg ybs harap segera langsung  dengan membawa Bukti Permintaan yang telah disahkan oleh Kasub.</marquee>

    </footer>

    <!-- jQuery 2.2.3 -->
    <script src="../assets/plugins/jQuery/jquery.min.js"></script>
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

    <!--tambah disini untuk metode tabel responsive-->
    <script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/plugins/datatables/dataTables.bootstrap.min.js"></script>

</body>
</html>
