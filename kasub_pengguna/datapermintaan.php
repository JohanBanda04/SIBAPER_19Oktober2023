<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

$subbidang_id = $_SESSION['subbidang_id'];

$sekarang = date('Y-m-d');
//echo $sekarang.'s';

//echo " subbidang_id = ".$subbidang_id;

//$query_old = mysqli_query($koneksi, "SELECT distinct(unit),
//instansi, tgl_permintaan FROM permintaan WHERE status=0");


$query_old = mysqli_query($koneksi, "Select * from sementara where status_acc='Pengajuan Kasub' 
and id_subbidang='$_SESSION[subbidang_id]' group by tgl_permintaan");


if (isset($_POST["tampilkan"])) {
    $tanggala = $_POST["tanggala"];
    $tanggalb = $_POST["tanggalb"];

    $_SESSION['tanggala']  = $tanggala;
    $_SESSION['tanggalb']  = $tanggalb;
//    echo $tanggala."-".$tanggalb;


    $query_old_1 = mysqli_query($koneksi, "Select * from sementara where 
id_subbidang='$_SESSION[subbidang_id]' and tgl_permintaan 
between '$tanggala' AND '$tanggalb' and status_acc !='Permintaan Baru' group by tgl_permintaan");

    $query = mysqli_query($koneksi, "Select * from sementara where 
id_subbidang='$_SESSION[subbidang_id]' and tgl_permintaan 
between '$tanggala' AND '$tanggalb' and status_acc ='Pengajuan Kasub' group by tgl_permintaan");

} else {
    if(isset($_SESSION['tanggala']) && isset($_SESSION['tanggalb'])){

        $query_old_2 = mysqli_query($koneksi, "Select * from sementara where 
id_subbidang='$_SESSION[subbidang_id]' and tgl_permintaan 
between '$_SESSION[tanggala]' AND '$_SESSION[tanggalb]' and status_acc !='Permintaan Baru' group by tgl_permintaan");

        $query = mysqli_query($koneksi, "Select * from sementara where 
id_subbidang='$_SESSION[subbidang_id]' and tgl_permintaan 
between '$_SESSION[tanggala]' AND '$_SESSION[tanggalb]' and status_acc ='Pengajuan Kasub' group by tgl_permintaan");
    } else {

        $query_old_3 = mysqli_query($koneksi, "Select * from sementara where 
id_subbidang='$_SESSION[subbidang_id]' and tgl_permintaan 
between '$sekarang' AND '$sekarang' and status_acc !='Permintaan Baru' group by tgl_permintaan");

        $query = mysqli_query($koneksi, "Select * from sementara where 
id_subbidang='$_SESSION[subbidang_id]' and tgl_permintaan 
between '$sekarang' AND '$sekarang' and status_acc ='Pengajuan Kasub' group by tgl_permintaan");
    }

}
?>
<!--filter 'acc_kasub=0' yg sebelumnya ada dihilangkan-->

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <?php
                        $query_get_nama_sub_bidang = mysqli_query($koneksi,"select * from subbidang
where id_subbidang='$_SESSION[subbidang_id]'");

                        while ($item = mysqli_fetch_array($query_get_nama_sub_bidang)){
                            $nama_subbidang = $item['nama_subbidang'];
                        }
                    ?>
                    <h3 class="text-center">Data Permintaan Barang <strong><?php echo $nama_subbidang; ?></strong></h3>
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

                        <!--                    <div class="form-group">-->
                        <!--                        <label>  Namas </label>&emsp;&emsp;-->
                        <!--                        <input type="text" id="unit" class="form-control" name="unit" required>-->
                        <!--                    </div>-->
                    </form>
                </center>

                <div class="box-body">
                    <div class="table-responsive">
                        <table id="datapesanan" class="table text-center">
                            <thead>

                            </thead>
                            <tbody>
                            <tr>
                                <?php
                                $no = 1;
                                if (mysqli_num_rows($query)) {
                                while ($row = mysqli_fetch_assoc($query)):
                                ?>
                                <!--Cetak tanggal disini :-->
                                <td style="color: #6d0000; font-weight: bold">
                                    <?= tanggal_indo($row['tgl_permintaan']); ?> :
                                </td>
                            </tr>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>User ID</th>
                                <th>Intansi</th>
                                <th>Aksi</th>
                            </tr>
                            <?php
                            $nomor = 1;


                            $query_filter_by_tanggal_old = mysqli_query($koneksi, "Select * from 
sementara where tgl_permintaan='$row[tgl_permintaan]'
and id_subbidang='$_SESSION[subbidang_id]' and status_acc !='Permintaan Baru' group by user_id");

                            $query_filter_by_tanggal = mysqli_query($koneksi, "Select * from 
sementara where tgl_permintaan='$row[tgl_permintaan]'
and id_subbidang='$_SESSION[subbidang_id]' and status_acc ='Pengajuan Kasub' group by user_id");

                            while ($dt = mysqli_fetch_array($query_filter_by_tanggal)) {
                                ?>
                                <tr>
                                       <td><?php echo $nomor;?></td>
                                       <td><?php echo $dt['unit'];?></td>
                                       <td><?php echo $dt['user_id'];?></td>
                                       <td><?php echo $dt['instansi'];?></td>
                                        <td>
                                            <!--                                        <a href="?p=detilpermintaan&unit=-->
                                            <?// echo $dt['unit']; ?><!--&tgl=-->
                                            <?// echo $dt['tgl_permintaan']; ?><!--&subbidang_id=-->
                                            <?php //echo $_SESSION['subbidang_id']; ?><!--&user_id_staf_pemohon=-->
                                            <?php //echo $dt['user_id'] ?><!--">-->
<!--                                            <a href="?p=detilpermintaan&unit=--><?// echo $dt['unit']; ?><!--&tgl=--><?// echo $dt['tgl_permintaan']; ?><!--&subbidang_id=--><?php //echo $_SESSION['subbidang_id']; ?><!--&user_id_staf_pemohon=--><?php //echo $dt['user_id'] ?><!--">-->
                                            <a href="?p=detilpermintaan&unit=<?php echo $dt['unit']?>&user_id=<?php echo $dt['user_id']?>&tgl_permintaan=<?php echo $dt['tgl_permintaan'];?>">
                                                                                <span data-placement='top'
                                                                                      data-toggle='tooltip'
                                                                                      title='Detail Permintaan'>
                                                                                    <button name="bt_detail_permintaan" type="submit" class="btn btn-info">
                                                                                        Detail Permintaan
                                                                                    </button>
                                                                                </span>
                                            </a>

                                        </td>

                                </tr>

                                <?php
                                $nomor++;
                            }

                            ?>
                            <?php
                            endwhile;
                            } else {
                                echo "<tr><td colspan=9>Tidak ada permintaan barang.</td></tr>";
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <span style="color: black">
            <!--index.php?p=history_kasub&pa=history_kasub_pengguna-->
        NB : Setelah semua permintaan disetujui/tidak disetujui, Anda dapat melihat posisi proses pada menu
<!--            <a style="font-weight: bold" href="?p=history_permintaan_barang&pa=history_pengguna">-->
<!--                History-->
<!--            </a>-->
            <a style="font-weight: bold" href="index.php?p=history_kasub&pa=history_kasub_pengguna">
                History
            </a>
    </span>

    </div>

</section>