<?php

//use
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";


$sekarang = date('Y-m-d');
//cek disini groupbynya

//$query_referensi_dari_kasub_pengguna = mysqli_query($koneksi, "Select * from sementara where
//id_subbidang='$_SESSION[subbidang_id]' and tgl_permintaan
//between '$tanggala' AND '$tanggalb' and status_acc !='Permintaan Baru' group by tgl_permintaan");





if(isset($_POST['tampilkan'])){
    $tanggala = $_POST['tanggala'];
    $tanggalb = $_POST['tanggalb'];

    $_SESSION['tanggala'] = $tanggala;
    $_SESSION['tanggalb'] = $tanggalb;

//    echo $tanggala."::";
//    echo $tanggalb."";

//metode penggunaan sql query OR dan AND
    $query = mysqli_query($koneksi,"select * from  (sementara inner join permintaan on 
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

} else {
    if(isset($_SESSION['tanggala']) && isset($_SESSION['tanggalb'])){


        $query = mysqli_query($koneksi,"select * from  (sementara inner join permintaan on 
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
    } else {



        $query = mysqli_query($koneksi,"select * from  (sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) 
where (sementara.tgl_permintaan between '$sekarang' and '$sekarang' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id='$_SESSION[user_id]') 
or
(sementara.tgl_permintaan between '$sekarang' and '$sekarang' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id is null) 
group by sementara.tgl_permintaan DESC");


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
                    <h3 class="text-center">bData Permintaan Barang</h3>
                </div>

                <center>
                    <!--                    <form method="POST" action="filter_permintaan_by_range_tgl.php" class="form-inline">-->
                    <form method="POST" class="form-inline">
                        <div class="box-body">

                            <div class="form-group">
                                <label> Dari Tanggal </label>
                                <input value="<?php if(isset($_SESSION['tanggala'])){ echo $_SESSION['tanggala']; } else { echo $sekarang; } ?>"
                                       type="date"  id="tanggala"
                                       class="form-control" name="tanggala" required>
                            </div>&emsp;
                            <div class="form-group">
                                <label> Sampai Tanggal </label>
                                <input value="<?php if(isset($_SESSION['tanggalb'])){ echo $_SESSION['tanggalb']; } else { echo $sekarang; } ?>"
                                       type="date" id="tanggalb"
                                       class="form-control" name="tanggalb" required>
                            </div>
                            &emsp;


                            <div class="form-group">&emsp;
                                <input type='submit' name="tampilkan" value="Lihat" class='btn btn-success'>
                            </div>
                        </div>

                    </form>
                </center>

                <div class="box-body">
                    <div class="table-responsive">
                        <table id="datapesanan" class="table text-center">
                            <thead >
<!--                            <tr>-->
<!--                                <th>No</th>-->
<!--                                <th>User ID</th>-->
<!--                                <th>Tanggal Permintaan</th>-->
<!--                                <th>Nama</th>-->
<!--                                <th>Intansi</th>-->
<!--                                <th>Aksi</th>-->
<!--                            </tr>-->
                            </thead>
                            <tbody>
                            <tr>
                                <?php
                                    $no =1;
                                    if(mysqli_num_rows($query)){
                                        while($row = mysqli_fetch_array($query)){ ?>
                                            <!--Cetak Tanggal Disini-->
                                            <td style="color: #6d0000; font-weight: bold">
                                                <?php echo tanggal_indo($row['tgl_permintaan'])?> :
                                            </td>

                            </tr>
                            <tr>
                                <th>No</th>
                                <th>User ID</th>
                                <th>ID Sementara</th>

                                <th>Nama</th>
                                <th>Intansi</th>
                                <th>Aksi</th>
                            </tr>
                            <?php
                                $nomor = 1;


                            $query_filter_by_tanggal = mysqli_query($koneksi,"select * from  
(sementara inner join permintaan on 
sementara.id_sementara=permintaan.id_sementara) 
where (sementara.tgl_permintaan='$row[tgl_permintaan]' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id='$_SESSION[user_id]')
or
(sementara.tgl_permintaan='$row[tgl_permintaan]' 
and sementara.status_acc in ('Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara',
'Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai') 
and sementara.bendahara_id is null)
group by sementara.user_id");

                                while($dt = mysqli_fetch_array($query_filter_by_tanggal)) { ?>
                                    <tr>
                                        <td><?php echo $nomor?></td>
                                        <td><?php echo $dt['user_id'];?></td>
                                        <td><?php echo $dt['id_sementara'];?></td>
                                        <td><?php echo $dt['unit'];?></td>
                                        <td><?php echo $dt['instansi'];?></td>
                                        <td>
                                            <a href="?p=detilpermintaan&unit=<?= $dt['unit'];?>&tgl=<?= $dt['tgl_permintaan']; ?>&user_id_pemohon=<?php echo $dt['user_id'];?>&bendahara_id=<?php echo $dt['bendahara_id']; ?>">
                                        <span data-placement='top' data-toggle='tooltip' title='Detail Permintaan'>
                                            <button class="btn btn-info">Detail Permintaan</button>
                                        </span>
                                            </a>

                                        </td>
                                    </tr>
                                <?php
                                $nomor++;
                                }
                            ?>
                                        <?php } } ?>



<!--                            --><?php //$no++; }
//                                } else {echo "<tr><td colspan=9>Tidak ada permintaan barang.</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>