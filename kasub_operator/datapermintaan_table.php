<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

$subbidang_id = $_SESSION['subbidang_id'];

$sekarang = date('Y-m-d');
$tgl_satu_bulan_lalu = date('Y-m-d',strtotime("-1 month"));
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

    $query_bk_1 = mysqli_query($koneksi, "Select * from sementara where tgl_permintaan
between '$tanggala' AND '$tanggalb' and status_acc='Pengajuan Kasub Bendahara' group by tgl_permintaan desc");

    $query = mysqli_query($koneksi, "Select * from sementara where tgl_permintaan
between '$tanggala' AND '$tanggalb' and status_acc='Pengajuan Kasub Bendahara' group by tgl_permintaan desc,user_id");

} else {
    if(isset($_SESSION['tanggala']) && isset($_SESSION['tanggalb'])){

        $query_bk_2 = mysqli_query($koneksi, "Select * from sementara where tgl_permintaan
between '$_SESSION[tanggala]' AND '$_SESSION[tanggalb]' and status_acc='Pengajuan Kasub Bendahara' 
group by tgl_permintaan desc");

        $query = mysqli_query($koneksi, "Select * from sementara where tgl_permintaan
between '$_SESSION[tanggala]' AND '$_SESSION[tanggalb]' and status_acc='Pengajuan Kasub Bendahara' 
group by tgl_permintaan desc,user_id");
    } else {

        $query_bk_3 = mysqli_query($koneksi, "Select * from sementara where tgl_permintaan
between '$sekarang' AND '$sekarang' and status_acc='Pengajuan Kasub Bendahara' group by tgl_permintaan desc");

        $query = mysqli_query($koneksi, "Select * from sementara where tgl_permintaan
between '$tgl_satu_bulan_lalu' AND '$sekarang' and status_acc='Pengajuan Kasub Bendahara' group by tgl_permintaan desc,user_id");
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
                    <h3 class="text-center">Data Permintaan Barang</h3>
                </div>
                <center>
                    <!--                    <form method="POST" action="filter_permintaan_by_range_tgl.php" class="form-inline">-->
                    <form method="POST" class="form-inline">
                        <div class="box-body">

                            <div class="form-group">
                                <label> Dari Tanggal </label>
                                <input value="<?php if(isset($_SESSION['tanggala'])){ echo $_SESSION['tanggala']; } else { echo $tgl_satu_bulan_lalu; } ?>" type="date"  id="tanggala"
                                       class="form-control" name="tanggala" required>
                            </div>&emsp;
                            <div class="form-group">
                                <label> Sampai Tanggal </label>
                                <input value="<?php if(isset($_SESSION['tanggalb'])){ echo $_SESSION['tanggalb']; } else { echo $sekarang; } ?>" type="date" id="tanggalb"
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
                        <table id="datapermintaan_table_side_kasub_operator" class="table text-center">
                            <thead style="background-color: #a1d5ff">
                            <tr>
                                <th>No</th>
                                <!--                                <th>Bendahara Brg</th>-->
                                <th>Nama</th>
                                <th>Pengelola</th>
                                <th>User ID</th>
                                <th>Tgl Permintaan</th>
                                <th>Intansi</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $no = 1;
                                if(mysqli_num_rows($query)){
                                    while($dt = mysqli_fetch_array($query)){ ?>
                                        <tr>
                                            <td><?php echo $no;?></td>
                                            <td>
                                                <?php

                                                $query_get_nama_pemohon = mysqli_query($koneksi, "Select nama_lengkap from `user` where id_user='$dt[user_id]'");
                                                echo mysqli_fetch_assoc($query_get_nama_pemohon)['nama_lengkap'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php

                                                $query_get_nama_bendahara = mysqli_query($koneksi, "Select nama_lengkap from `user` where id_user='$dt[bendahara_id]'");
                                                echo mysqli_fetch_assoc($query_get_nama_bendahara)['nama_lengkap'];
                                                ?>
                                            </td>
                                            <td><?php echo tanggal_indo($dt['tgl_permintaan']);?></td>
                                            <td><?php echo $dt['user_id'];?></td>
                                            <td><?php echo $dt['instansi'];?></td>
                                            <td>
                                                <a href="index.php?p=detilpermintaan_table&unit=<?php echo $dt['unit']?>&user_id=<?php echo $dt['user_id']?>&tgl_permintaan=<?php echo $dt['tgl_permintaan'];?>">
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

    <div>
        <span style="color: black">
<!--            index.php?p=history_kasub&pa=history_kasub_operator-->
        NB : Setelah semua permintaan dari Bendahara disetujui, Anda dapat melihat posisi proses pada menu
            <a style="font-weight: bold" href="index.php?p=history_kasub_operator_table&pa=history_kasub_operator">
                History
            </a>
    </span>

    </div>

</section>

<script>
    $(function(){
        $("#datapermintaan_table_side_kasub_operator").DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            }
        });
    });
</script>