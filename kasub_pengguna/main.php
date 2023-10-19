<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">


        <?php
        include "../fungsi/koneksi.php";


        $query_jml_permintaan = mysqli_query($koneksi, "select count(*) as jml_permintaan from sementara where id_subbidang=$_SESSION[subbidang_id] and status_acc='Pengajuan Kasub'");
        ?>
        <div class="col-lg-4 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-blue" style="border-radius: 20px">
                <div class="inner">
                    <p>
                        <font size="5px"><b>Data Permintaan Barang
                                <span class="" style="border-color: red; border-radius: 20px; width: 100%; padding: 5px">
                        <?php
                        $dt = mysqli_fetch_assoc($query_jml_permintaan);
                        echo " : ".$dt['jml_permintaan'];
                        ?>
                    </span>
                            </b>
                        </font>
                    </p>
                    <p>Olah Data Permintaan Barang </p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
<!--                <a href="index.php?p=datapermintaan" class="small-box-footer">Info Lebih Lanjut <i class="fa fa-arrow-circle-right"></i></a>-->
                <a href="index.php?p=datapermintaan_table&pas=permintaanbarang" class="small-box-footer" style="border-bottom-left-radius: 25px; border-bottom-right-radius: 25px; ">Info Lebih Lanjut <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-green" style="border-radius: 25px">
                <div class="inner">
                    <p><font size="5px"><b>History Permintaan Barang</b></font></p>
                    <p>History Permintaan Barang</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="index.php?p=history_kasub_table&pa=history_kasub_pengguna" class="small-box-footer" style="border-bottom-left-radius: 25px; border-bottom-right-radius: 25px; ">Info Lebih Lanjut <i
                            class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>


</section>