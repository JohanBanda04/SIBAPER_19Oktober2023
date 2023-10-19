<?php
session_start();
ob_start();
//include "cekuser.php";
include "../fungsi/koneksi.php";

$page = isset($_GET['p']) ? $_GET['p'] : false;
$query = mysqli_query($koneksi, "SELECT count(*) as jumlah FROM jenis_barang where jenis_brg NOT IN ('ALAT KEBERSIHAN','PERLENGKAPAN LAINNYA')");
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
        <div class="logo" style="background-color: #121619">

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
                            class="text-center"><?php if($_SESSION['jabatan']=="Operator"){
                            echo isset($_SESSION['jabatan'])?  "Pengelola Persediaan <br> Barang <br>": "Anda Belum Login" ;
                        } ?> <span style="font-weight: bold"><?php echo isset($_SESSION['nama_lengkap'])? ($_SESSION['nama_lengkap']):'Anda Belum Login'; ?></span></h4></li>

<!--                <li class="header"><h4-->
<!--                            class="text-center">--><?php //if($_SESSION['jabatan']=="Operator"){
//                                echo "Pengelola Persediaan";
//                        } ?><!-- <br> --><?php //echo "Barang"; ?><!--<br>  <span style="font-weight: bold">--><?//= $_SESSION['username']; ?><!--</span></h4></li>-->
                <li class="active treeview">
                    <a href="index.php?pa=Dashboard" style="<?php if (isset($_GET['pa'])){
                        if($_GET['pa']=='Dashboard'){
                            ?> background-color: #c7fff1; opacity: 80%; font-weight: bold; <?php
                        }
                    } ?>">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="<?php if (isset($_GET['pa'])){
                    if($_GET['pa']=='DataUser'){
                        ?> active <?php
                    }
                } ?>">
                    <a href="index.php?p=user&pa=DataUser" style="<?php if (isset($_GET['p'])){
                        if($_GET['p']=='tambahuser'){
                            ?>
                                background-color: #c7fff1; opacity: 80%; font-weight: bold;
                            <?php
                        } else if ($_GET['p']=='user'){
                            ?>
                                background-color: #c7fff1; opacity: 80%; font-weight: bold;
                            <?php
                        } else if ($_GET['p']=='edituser'){
                            ?>
                                background-color: #c7fff1; opacity: 80%; font-weight: bold;
                            <?php
                        }
                    } else if (isset($_GET['pa'])){
                        if($_GET['pa']=='DataUser'){
                        ?>
                                background-color: #c7fff1; opacity: 80%; font-weight: bold;
                            <?php
                        }
                    }?>"><i class="fa fa-users"></i>
                        <span>Data User</span>
                    </a>
                </li>
                <!--                <li class="treeview active" style="">-->
                <li class="treeview
                           <?php if(isset($_GET['pas'])){
                               if ($_GET['pas'] == 'atk' || $_GET['pas'] == 'alatkebersihan' || $_GET['pas'] == 'perlengkapanlainnya' || $_GET['pas'] == 'olipelumas' || $_GET['pas'] == 'non-atk') {
                                   ?> active <?php
                               }
                           } else if (isset($_GET['p'])){
                               if($_GET['p']=='tambahmaterial-m1'){
                                    ?> active <?php
                               } else if ($_GET['p']=='tambahmaterial-m2'){
                                    ?> active <?php
                               } else if ($_GET['p']=='tambahmaterial-m3'){
                                   ?> active <?php
                               } else if ($_GET['p']=='tambahmaterial-m4'){?>
                                      active
                                <?php}else if($_GET['p']=='edit-m1'){
                                   ?> active <?php
                               } else if ($_GET['p']=='edit-m2'){
                                   ?> active <?php
                               } else if ($_GET['p']=='edit-m3'){
                                   ?> active <?php
                               } else if ($_GET['p']=='edit-m4'){ ?>
                                    active
                                <?php }
                }?>
               "
                    style="">
                    <a href="index.php?pa=DataStokBarang"
                       style="<?php if ((isset($_GET['pas']) && $_GET['pas'] == 'atk') || (isset($_GET['pas']) && $_GET['pas'] == 'alatkebersihan') || (isset($_GET['pas']) && $_GET['pas'] == 'perlengkapanlainnya') || (isset($_GET['pas']) && $_GET['pas'] == 'olipelumas') || (isset($_GET['pas']) && $_GET['pas'] == 'non-atk')) { ?>
                               background-color: #c7fff1; opacity: 85%; font-weight: bold;
                       <?php } else if (isset($_GET['p'])){
                            if($_GET['p']=='tambahmaterial-m1'){
                                ?>
                                    background-color: #c7fff1; opacity: 85%; font-weight: bold;
                                <?php
                            } else if ($_GET['p']=='tambahmaterial-m2'){
                                ?>
                                    background-color: #c7fff1; opacity: 85%; font-weight: bold;
                                <?php
                            } else if ($_GET['p']=='tambahmaterial-m3'){
                                ?>
                                    background-color: #c7fff1; opacity: 85%; font-weight: bold;
                                <?php
                            } else if ($_GET['p']=='tambahmaterial-m4'){ ?>
                                    background-color: #c7fff1; opacity: 85%; font-weight: bold;
                            <?php } else if ($_GET['p']=='edit-m1'){
                                ?>
                                    background-color: #c7fff1; opacity: 85%; font-weight: bold;
                                <?php
                            } else if ($_GET['p']=='edit-m2'){
                                ?>
                                    background-color: #c7fff1; opacity: 85%; font-weight: bold;
                                <?php
                            } else if ($_GET['p']=='edit-m3'){
                                ?>
                                    background-color: #c7fff1; opacity: 85%; font-weight: bold;
                                <?php
                            } else if ($_GET['p']=='edit-m4'){?>
                                    background-color: #c7fff1; opacity: 85%; font-weight: bold;
                                <?php
                            }
                       } ?>">
                        <i class="fa fa-cubes"></i>
                        <span style="">Data Stok Barangs</span>
                        <span class="pull-right-container">
            <span class="label label-primary pull-right"><?= $data['jumlah']; ?></span>
          </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php
                            $query_get_kategori = mysqli_query($koneksi,"select * from jenis_barang");

                            foreach ($query_get_kategori as $index=>$value){
                                if($value['jenis_brg']!="ALAT KEBERSIHAN" && $value['jenis_brg']!="PERLENGKAPAN LAINNYA"){
                                    $nama_kategori = strtolower($value['jenis_brg']);

                                    $trimmed_nama_kategori = str_replace(" ","",$nama_kategori); ?>
                                    <li style="<?php if(isset($_GET['pas'])){
                                        if ($_GET['pas'] == $trimmed_nama_kategori) { ?> background-color: #87b2a4 <?php } }?>
                                            ">
                                        <!--output dari p = 'material-m1'-->
                                        <a href="index.php?p=material-m<?php echo $value['id_jenis'];?>&id_jenis=<?php echo $value['id_jenis'];?>&pas=<?php echo $trimmed_nama_kategori;?>">
                                            <i class="fa fa-circle-o"></i><?php echo $value['jenis_brg'];?>

                                        </a>
                                    </li>
                                    <?php

                                }

                                ?>


                            <?php }
                        ?>

                    </ul>
                </li>

                <!--ori yang disembunyikan-->
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
                        <li style="<?php if ($_GET['pas'] == 'permintaanbarang') { ?> background-color: #87b2a4 <?php } ?>">
                            <a href="index.php?p=datapermintaan&pas=permintaanbarang">
                                <i class="fa fa-circle-o"></i>Permintaan Barang
                            </a>
                        </li>
                    </ul>


                    <ul class="treeview-menu">
                        <li style="<?php if ($_GET['pas'] == 'datapermintaanbarang') { ?> background-color: #87b2a4 <?php } ?>">
                            <a href="index.php?p=datapengeluaran&pas=datapermintaanbarang"><i
                                        class="fa fa-circle-o"></i>Data Permintaan Barang
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview
                <?php if(isset($_GET['pas'])){
                if ($_GET['pas'] == 'permintaanbarang' || $_GET['pas'] == 'datapermintaanbarang') { ?>
                active
                <?php
                }
                } else if (isset($_GET['p'])){
                    if($_GET['p']=='detilpermintaan_table'){
                        ?> active <?php
                    } else if ($_GET['p']=='sudah_serahkan_barang_ke_pengguna_table'){
                        ?> active <?php
                    } else if ($_GET['p']=='detil_datapengeluaran_table'){
                        ?> active <?php
                    } else if ($_GET['p']=='edit_permintaan_pengguna'){
                        ?> active <?php
                    }
                } ?>
                 ">
                    <a href="index.php?pa=PermintaanBarang"
                       style="<?php if ((isset($_GET['pas']) && $_GET['pas'] == 'permintaanbarang') || (isset($_GET['pas']) && $_GET['pas'] == 'datapermintaanbarang')) { ?>
                               background-color: #c7fff1; opacity: 85%;
                       <?php } else if (isset($_GET['p'])){
                           if($_GET['p']=='detilpermintaan_table'){
                               ?> background-color: #c7fff1; opacity: 85%; <?php
                           } else if ($_GET['p']=='sudah_serahkan_barang_ke_pengguna_table'){
                               ?> background-color: #c7fff1; opacity: 85%; <?php
                           } else if ($_GET['p']=='detil_datapengeluaran_table'){
                               ?> background-color: #c7fff1; opacity: 85%; <?php
                           } else if ($_GET['p']=='edit_permintaan_pengguna'){
                               ?> background-color: #c7fff1; opacity: 85%; <?php
                           }
                       } ?>">
                        <i class="fa fa-retweet"></i>
                        <span>Permintaan Barang <!--Table--></span>
                        <span class="pull-right-container">
          <span class="label label-primary pull-right"></span>
        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li style="<?php if(isset($_GET['pas'])){
                            if($_GET['pas'] == 'permintaanbarang'){
                            ?> background-color: #87b2a4; <?php
                            }
                        } else if (isset($_GET['p'])){
                            if($_GET['p']=='detilpermintaan_table'){
                                ?> background-color: #87b2a4; <?php
                            } else if ($_GET['p']=='sudah_serahkan_barang_ke_pengguna_table'){
                                ?> background-color: #87b2a4; <?php
                            } else if ($_GET['p']=='edit_permintaan_pengguna'){
                                ?> background-color: #87b2a4; <?php
                            }
                        }?>">
                            <a href="index.php?p=datapermintaan_table&pas=permintaanbarang">
                                <i class="fa fa-circle-o"></i>Permintaan Barang <!--Table-->
                            </a>
                        </li>
                    </ul>


                    <ul class="treeview-menu">
                        <li style="<?php if (isset($_GET['pas'])){
                            if ($_GET['pas'] == 'datapermintaanbarang'){
                                ?> background-color: #87b2a4; <?php
                            }
                        } else if (isset($_GET['p'])){
                            if($_GET['p']=='detil_datapengeluaran_table'){
                                ?> background-color: #87b2a4; <?php
                            }
                        } ?>">
                            <a href="index.php?p=datapengeluaran_table&pas=datapermintaanbarang"><i
                                        class="fa fa-circle-o"></i>Data Permintaan Barang <!--Table-->
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview <?php
                    if(isset($_GET['pas'])){
                if ($_GET['pas'] == 'formpengajuan' || $_GET['pas'] == 'datapengajuan') { ?> active <?php }
                    } else if (isset($_GET['p'])){
                        if($_GET['p']=='formpengajuan_table'){
                            ?> active <?php
                        } else if($_GET['p']=='detilpengajuan_table'){
                            ?> active <?php
                        }
                    } ?>

                ">
                    <a href="index.php?pa=PengajuanBarang"
                       style="<?php if ((isset($_GET['pas']) && $_GET['pas'] == 'formpengajuan') || (isset($_GET['pas']) && $_GET['pas'] == 'datapengajuan')) { ?>
                               background-color: #c7fff1; opacity: 85%;
                       <?php } else if (isset($_GET['p'])){
                           if($_GET['p']=='formpengajuan_table'){
                               ?> background-color: #c7fff1; opacity: 85%; <?php
                           } else if ($_GET['p']=='detilpengajuan_table'){
                               ?> background-color: #c7fff1; opacity: 85%; <?php
                           }
                       }?>">
                        <i class="fa fa-pencil-square"></i>
                        <span>Pengajuan Barang</span>
                        <span class="pull-right-container">
          <span class="label label-primary pull-right"></span>
        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li style="<?php if(isset($_GET['pas'])){
                            if($_GET['pas'] == 'formpengajuan'){
                                ?> background-color: #87b2a4 <?php
                            }
                        } ?>">
                            <a href="index.php?p=formpengajuan_table&pas=formpengajuan">
                                <i class="fa fa-circle-o"></i>Form Pengajuan Barang
                            </a>
                        </li>
                    </ul>

                    <!--ori yang disembunyikan-->
                    <ul class="hide treeview-menu">
                        <li style="<?php if ($_GET['pas'] == 'datapengajuan') { ?> background-color: #87b2a4 <?php } ?>">
                            <a href="index.php?p=datapengajuan&pas=datapengajuan">
                                <i class="fa fa-circle-o"></i>Data Pengajuan Barang
                            </a>
                        </li>
                    </ul>
                    <ul class="treeview-menu">
                        <li style="<?php if (isset($_GET['pas'])){
                            if ($_GET['pas'] == 'datapengajuan'){
                                ?> background-color: #87b2a4; <?php
                            }
                        } else if (isset($_GET['p'])){
                            if($_GET['p']=='formpengajuan_table'){
                                ?> background-color: #87b2a4; <?php
                            } else if ($_GET['p']=='detilpengajuan_table'){
                                ?> background-color: #87b2a4; <?php
                            }
                        } ?>">
                            <a href="index.php?p=datapengajuan_table&pas=datapengajuan">
                                <i class="fa fa-circle-o"></i>Data Pengajuan Barang <!--Table-->
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview
                <?php if(isset($_GET['pas'])){
                if ($_GET['pas'] == 'detil_lap_permintaan' || $_GET['pas'] == 'rekapitulasipermintaan') { ?>
                active
                <?php }
                } else if (isset($_GET['p'])){
                    if ($_GET['p']=='detil_lap_permintaan'){
                        ?> active <?php
                    }
                }?>

                ">
                    <a href="index.php?pa=LaporanPermintaanBarang"
                       style="<?php if ((isset($_GET['pas']) && $_GET['pas'] == 'detil_lap_permintaan') || (isset($_GET['pas']) && $_GET['pas'] == 'rekapitulasipermintaan')) { ?>background-color: #c7fff1; opacity: 85%<?php } ?>">
                        <i class="fa fa-file-pdf-o"></i>
                        <span>Laporan Permintaan Barang</span>
                        <span class="pull-right-container">
          <span class="label label-primary pull-right"></span>
        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li style="<?php if (isset($_GET['pas'])){
                            if($_GET['pas'] == 'detil_lap_permintaan'){
                            ?> background-color: #87b2a4 <?php
                            }
                        } ?>">
                            <a href="index.php?p=detil_lap_permintaan&pas=detil_lap_permintaan">
                                <i class="fa fa-circle-o"></i>Detil Laporan Permintaan
                            </a>
                        </li>
                    </ul>
                    <ul class="treeview-menu">
                        <li style="<?php if (isset($_GET['pas'])){
                            if($_GET['pas'] == 'rekapitulasipermintaan'){
                                ?> background-color: #87b2a4 <?php
                            }
                        } ?>">
                            <a href="index.php?p=rekapitulasipermintaan&pas=rekapitulasipermintaan">
                                <i class="fa fa-circle-o"></i>Rekapitulasi Permintaan
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview <?php if(isset($_GET['pas'])){
                if ($_GET['pas'] == 'detil_lap_pengajuan' || $_GET['pas'] == 'rekapitulasipengajuan') { ?> active <?php } }?>
                ">
                    <a href="index.php?pa=LaporanPengajuanBarang"
                       style="<?php if ((isset($_GET['pas']) && $_GET['pas'] == 'detil_lap_pengajuan') || (isset($_GET['pas']) && $_GET['pas'] == 'rekapitulasipengajuan')) { ?>background-color: #c7fff1; opacity: 85%<?php } ?>">
                        <i class="fa fa-file-pdf-o"></i>
                        <span>Laporan Pengajuan Barang</span>
                        <span class="pull-right-container">
          <span class="label label-primary pull-right"></span>
        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li style="<?php if (isset($_GET['pas'])){
                            if($_GET['pas'] == 'detil_lap_pengajuan'){
                            ?> background-color: #87b2a4 <?php
                            }
                        } ?>">
                            <a href="index.php?p=detil_lap_pengajuan&pas=detil_lap_pengajuan">
                                <i class="fa fa-circle-o"></i>Detil Laporan Pengajuan
                            </a>
                        </li>
                    </ul>
                    <ul class="treeview-menu">
                        <li style="<?php if (isset($_GET['pas'])){
                            if($_GET['pas'] == 'rekapitulasipengajuan'){
                            ?> background-color: #87b2a4 <?php
                            }
                        } ?>">
                            <a href="index.php?p=rekapitulasipengajuan&pas=rekapitulasipengajuan">
                                <i class="fa fa-circle-o"></i>Rekapitulasi Pengajuan
                            </a>
                        </li>
                    </ul>
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
        <marquee hspace="40" width="full-width">Pengelola Persediaan Barang Mengelola Data User dan Data Stok Barang.</marquee>
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

<!--    <script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>-->
<!--    <script src="../assets/plugins/datatables/dataTables.bootstrap.min.js"></script>-->

    <!--tambah disini untuk metode tabel responsive-->
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
