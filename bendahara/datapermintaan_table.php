<?php

//use
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";


$sekarang = date('Y-m-d');
$tgl_satu_bulan_lalu = date('Y-m-d',strtotime('-1 month'));
//cek disini groupbynya

//$query_referensi_dari_kasub_pengguna = mysqli_query($koneksi, "Select * from sementara where
//id_subbidang='$_SESSION[subbidang_id]' and tgl_permintaan
//between '$tanggala' AND '$tanggalb' and status_acc !='Permintaan Baru' group by tgl_permintaan");


$_SESSION['sesi_jenis_barang']="";
$_SESSION['sesi_kode_barang']="";
$_SESSION['sesi_kode_barang_lengkap']="";

//echo $_SESSION['sesi_kode_barang_lengkap']; die;
//echo $_SESSION['user_id']; die;

if (isset($_POST['tampilkan'])) {
    $tanggala = $_POST['tanggala'];
    $tanggalb = $_POST['tanggalb'];

    $_SESSION['tanggala'] = $tanggala;
    $_SESSION['tanggalb'] = $tanggalb;

    $kode_barang = $_POST['kode_barang'];
    $_SESSION['sesi_kode_barang_lengkap'] = $_POST['kode_barang'];

//    echo $tanggala."::";
//    echo $tanggalb."";
    //echo $tanggala."::";
    //echo $tanggalb."::";
    //echo "kode brg::".$kode_barang."::";

    if(isset($_SESSION['sesi_kode_barang_lengkap'])){
        if($_SESSION['sesi_kode_barang_lengkap']!=""){
            //echo "Sesi Kode Barang Terset dan Ada Isi : ".$_SESSION['sesi_kode_barang_lengkap']."<br>";

            $query = mysqli_query($koneksi, "select * from  (sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) 
where (sementara.tgl_permintaan between '$tanggala' and '$tanggalb' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.kode_brg='$_SESSION[sesi_kode_barang_lengkap]'
and sementara.bendahara_id='$_SESSION[user_id]')
or
(sementara.tgl_permintaan between '$tanggala' and '$tanggalb' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai')
and sementara.kode_brg='$_SESSION[sesi_kode_barang_lengkap]' 
and sementara.bendahara_id is null) 
group by sementara.tgl_permintaan DESC,sementara.unit");
        } else if($_SESSION['sesi_kode_barang_lengkap']==""){
            //echo "Sesi Kode Barang Terset dan Tidak Ada Isi alias Kosongan : <br>";
            $query = mysqli_query($koneksi, "select * from  (sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) 
where (sementara.tgl_permintaan between '$tanggala' and '$tanggalb' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id='$_SESSION[user_id]')
or
(sementara.tgl_permintaan between '$tanggala' and '$tanggalb' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai')
and sementara.bendahara_id is null) 
group by sementara.tgl_permintaan DESC,sementara.unit");
        }
    } else if(!isset($_SESSION['sesi_kode_barang_lengkap'])){
        //echo "Sesi Kode Barang Tidak Terset dan Tidak Ada Isi : <br>";
        /*kukos*/
        $query = mysqli_query($koneksi, "select * from  (sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) 
where (sementara.tgl_permintaan between '$tanggala' and '$tanggalb' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id='$_SESSION[user_id]')
or
(sementara.tgl_permintaan between '$tanggala' and '$tanggalb' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai')
and sementara.bendahara_id is null) 
group by sementara.tgl_permintaan DESC,sementara.unit");
    }

    $query_bk_1 = mysqli_query($koneksi, "select * from  (sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) 
where (sementara.tgl_permintaan between '$tanggala' and '$tanggalb' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id='$_SESSION[user_id]') 
or
(sementara.tgl_permintaan between '$tanggala' and '$tanggalb' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id is null) 
group by sementara.tgl_permintaan DESC");

    $query_old_v1 = mysqli_query($koneksi, "select * from  (sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) 
where (sementara.tgl_permintaan between '$tanggala' and '$tanggalb' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id='$_SESSION[user_id]')
or
(sementara.tgl_permintaan between '$tanggala' and '$tanggalb' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id is null) 
group by sementara.tgl_permintaan DESC,sementara.unit");

} else {
    if (isset($_SESSION['tanggala']) && isset($_SESSION['tanggalb'])) {


        if(isset($_SESSION['sesi_kode_barang_lengkap'])){
            if($_SESSION['sesi_kode_barang_lengkap']!=""){
                $query = mysqli_query($koneksi, "select * from  (sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) 
where (sementara.tgl_permintaan between '$tanggala' and '$tanggalb' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.kode_brg='$_SESSION[sesi_kode_barang_lengkap]'
and sementara.bendahara_id='$_SESSION[user_id]')
or
(sementara.tgl_permintaan between '$tanggala' and '$tanggalb' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai')
and sementara.kode_brg='$_SESSION[sesi_kode_barang_lengkap]' 
and sementara.bendahara_id is null) 
group by sementara.tgl_permintaan DESC,sementara.unit");
            } else if($_SESSION['sesi_kode_barang_lengkap']==""){
                $query = mysqli_query($koneksi, "select * from  (sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) 
where (sementara.tgl_permintaan between '$_SESSION[tanggala]' and '$_SESSION[tanggalb]' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id='$_SESSION[user_id]')
or
(sementara.tgl_permintaan between '$_SESSION[tanggala]' and '$_SESSION[tanggalb]' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai')
and sementara.bendahara_id is null) 
group by sementara.tgl_permintaan DESC,sementara.unit");
            }
        }
        $query_bk_2 = mysqli_query($koneksi, "select * from  (sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) 
where (sementara.tgl_permintaan between '$_SESSION[tanggala]' and '$_SESSION[tanggalb]' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id='$_SESSION[user_id]') 
or
(sementara.tgl_permintaan between '$_SESSION[tanggala]' and '$_SESSION[tanggalb]' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id is null) 
group by sementara.tgl_permintaan DESC");

        $query_old_v2 = mysqli_query($koneksi, "select * from  (sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) 
where (sementara.tgl_permintaan between '$_SESSION[tanggala]' and '$_SESSION[tanggalb]' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id='$_SESSION[user_id]')
or
(sementara.tgl_permintaan between '$_SESSION[tanggala]' and '$_SESSION[tanggalb]' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id is null) 
group by sementara.tgl_permintaan DESC,sementara.unit");
    } else {


        if(isset($_SESSION['sesi_kode_barang_lengkap'])){
            if($_SESSION['sesi_kode_barang_lengkap']!=""){
                $query = mysqli_query($koneksi, "select * from  (sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) 
where (sementara.tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.kode_brg='$_SESSION[sesi_kode_barang_lengkap]'
and sementara.bendahara_id='$_SESSION[user_id]')
or
(sementara.tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai')
and sementara.kode_brg='$_SESSION[sesi_kode_barang_lengkap]' 
and sementara.bendahara_id is null) 
group by sementara.tgl_permintaan DESC,sementara.unit");
            } else if($_SESSION['sesi_kode_barang_lengkap']==""){
                $query = mysqli_query($koneksi, "select * from  (sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) 
where (sementara.tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id='$_SESSION[user_id]')
or
(sementara.tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id is null) 
group by sementara.tgl_permintaan DESC,sementara.unit");
            }
        } else if(!isset($_SESSION['sesi_kode_barang_lengkap'])){
            $query = mysqli_query($koneksi, "select * from  (sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) 
where (sementara.tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id='$_SESSION[user_id]')
or
(sementara.tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id is null) 
group by sementara.tgl_permintaan DESC,sementara.unit");
        }


        $query_bk_3 = mysqli_query($koneksi, "select * from  (sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) 
where (sementara.tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id='$_SESSION[user_id]') 
or
(sementara.tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id is null) 
group by sementara.tgl_permintaan DESC");

        $query_old_v3 = mysqli_query($koneksi, "select * from  (sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) 
where (sementara.tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id='$_SESSION[user_id]')
or
(sementara.tgl_permintaan between '$tgl_satu_bulan_lalu' and '$sekarang' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id is null) 
group by sementara.tgl_permintaan DESC,sementara.unit");

    }

}


?>
<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Data Permintaan Barang</h3>
                </div>

                <center>
                    <!--                    <form method="POST" action="filter_permintaan_by_range_tgl.php" class="form-inline">-->
                    <form method="POST" class="form-inline">
                        <div class="box-body">

                            <div class="form-group">
                                <label> Dari Tanggals </label>
                                <input value="<?php if (isset($_SESSION['tanggala'])) {
                                    echo $_SESSION['tanggala'];
                                } else {
                                    echo $tgl_satu_bulan_lalu;
                                } ?>"
                                       type="date" id="tanggala"
                                       class="form-control" name="tanggala" required>
                            </div>&emsp;
                            <div class="form-group">
                                <label> Sampai Tanggal </label>
                                <input value="<?php if (isset($_SESSION['tanggalb'])) {
                                    echo $_SESSION['tanggalb'];
                                } else {
                                    echo $sekarang;
                                } ?>"
                                       type="date" id="tanggalb"
                                       class="form-control" name="tanggalb" required>
                            </div>
                            &emsp;
                            <div style="margin-top: 20px">

                            </div>

                            <div class="form-group">
                                <div class="col-sm-3">
                                    <select name="kode_barang" id="kode_barang"
                                            class="form-control">
                                        <option value="" class="text-center">--Jenis Barang--</option>
                                        <?php
                                            $query_get_brg = mysqli_query($koneksi,"select id_kode_brg,kode_brg,nama_brg from stokbarang");
                                            while($item = mysqli_fetch_array($query_get_brg)){ ?>
                                                <option <?php if($_SESSION['sesi_kode_barang_lengkap']==$item['kode_brg']){ ?>
                                                    selected
                                                <?php } ?> value="<?php echo $item['kode_brg'] ?>"
                                                        class="text-center">
                                                    <?php echo $item['nama_brg'];?>
                                                </option>
                                            <?php }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div style="margin-top: 20px">

                            </div>

                            <div class="form-group">&emsp;
                                <input type='submit' name="tampilkan" value="Lihat" class='btn btn-success'>
                            </div>
                        </div>

                    </form>
                </center>

                <div class="box-body">
                    <!--metode table responsive contoh baru-->
                    <div class="table-responsive">
                        <!--                        <table id="datapermintaan_table_side_bendahara" class="table text-center">-->
                        <table class="table text-center" id="datapermintaan_table_side_bendahara">
                            <thead style="background-color: #b6eee0">
                            <tr>
                                <th>Non</th>
<!--                                <th>User ID</th>-->
                                <th>Status</th>
                                <th>Tgl Permintaan</th>
                                <th>Nama</th>
                                <th>Intansi</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $no = 1;
                                if(mysqli_num_rows($query)){
                                    while($dt = mysqli_fetch_array($query)){
                                        ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
<!--                                            <td>--><?php //echo $dt['user_id']; ?><!--</td>-->
                                            <td><?php if($dt['status_acc']=='Pengajuan Kasub Bendahara'){
                                                    echo "Pengajuan Kasub Pengelola";
                                                } else if($dt['status_acc']=="Setuju Kasub Bendahara"){
                                                    echo "Setuju Kasub Pengelola";
                                                } else {
                                                    echo $dt['status_acc'];
                                                } ?></td>
                                            <td><?php echo tanggal_indo($dt['tgl_permintaan']); ?></td>
                                            <td><?php echo ucwords($dt['unit']); ?></td>
                                            <td><?php echo ucwords($dt['instansi']); ?></td>
                                            <td>
                                                <?php
                                                if(isset($_SESSION['sesi_kode_barang_lengkap'])){
                                                    if($_SESSION['sesi_kode_barang_lengkap']!=""){
                                                        ?>
                                                        <a href="?p=detilpermintaan_table&unit=<?= $dt['unit'];?>&tgl=<?= $dt['tgl_permintaan']; ?>&user_id_pemohon=<?php echo $dt['user_id'];?>&bendahara_id=<?php echo $dt['bendahara_id']; ?>&kode_brg_lengkap=<?php echo $_SESSION['sesi_kode_barang_lengkap']?>">
                                                            <span data-placement='top' data-toggle='tooltip' title='Detail Permintaan'>
                                                                <button class="btn btn-info">Detail Permintaan</button>
                                                            </span>
                                                        </a>
                                                        <?php
                                                    } else if($_SESSION['sesi_kode_barang_lengkap']==""){
                                                        ?>
                                                        <a href="?p=detilpermintaan_table&unit=<?= $dt['unit'];?>&tgl=<?= $dt['tgl_permintaan']; ?>&user_id_pemohon=<?php echo $dt['user_id'];?>&bendahara_id=<?php echo $dt['bendahara_id']; ?>">
                                                            <span data-placement='top' data-toggle='tooltip' title='Detail Permintaan'>
                                                                <button class="btn btn-info">Detail Permintaan</button>
                                                            </span>
                                                        </a>
                                                        <?php
                                                    }
                                                } else if(!isset($_SESSION['sesi_kode_barang_lengkap'])){
                                                    ?>
                                                    <a href="?p=detilpermintaan_table&unit=<?= $dt['unit'];?>&tgl=<?= $dt['tgl_permintaan']; ?>&user_id_pemohon=<?php echo $dt['user_id'];?>&bendahara_id=<?php echo $dt['bendahara_id']; ?>">
                                                            <span data-placement='top' data-toggle='tooltip' title='Detail Permintaan'>
                                                                <button class="btn btn-info">Detail Permintaan</button>
                                                            </span>
                                                    </a>
                                                    <?php
                                                }
                                                ?>
<!--                                                <a href="?p=detilpermintaan_table&unit=--><?//= $dt['unit'];?><!--&tgl=--><?//= $dt['tgl_permintaan']; ?><!--&user_id_pemohon=--><?php //echo $dt['user_id'];?><!--&bendahara_id=--><?php //echo $dt['bendahara_id']; ?><!--">-->
<!--                                                    <span data-placement='top' data-toggle='tooltip' title='Detail Permintaan'>-->
<!--                                                        <button class="btn btn-info">Detail Permintaan</button>-->
<!--                                                    </span>-->
<!--                                                </a>-->

                                            </td>
                                        </tr>
                                    <?php $no++; }
                                }
                            ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>

    $(function () {
        $("#datapermintaan_table_side_bendahara").DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            }
        });
    });
</script>