<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

if (isset($_GET['aksi']) && isset($_GET['tgl'])) {
    //die($id = $_GET['id']);
    $tgl = $_GET['tgl'];
    echo $tgl;

    if ($_GET['aksi'] == 'detil') {
        header("location:?p=detil&tgl=$tgl");
    }
}

$query_bk = mysqli_query($koneksi, "SELECT unit, tgl_pengajuan, count(kode_brg) 
FROM pengajuan WHERE unit= '$_SESSION[username]'  GROUP BY tgl_pengajuan");

$query_bk_2 = mysqli_query($koneksi, "	SELECT *, count(kode_brg) 
FROM pengajuan WHERE unit= '$_SESSION[username]' and user_id='$_SESSION[user_id]' 
and !isnull(id_pengajuan_sementara) GROUP BY tgl_pengajuan DESC");

/*cara select all dengan koma setelahnya*/
$query_bk_3 = mysqli_query($koneksi, "	SELECT *, count(pengajuan.kode_brg) 
FROM  (pengajuan inner join pengajuan_sementara on pengajuan.id_pengajuan_sementara=pengajuan_sementara.id_pengajuan_sementara) 
WHERE pengajuan_sementara.unit='$_SESSION[username]' and pengajuan_sementara.user_id='$_SESSION[user_id]' 
and !isnull(pengajuan_sementara.id_pengajuan_sementara) GROUP BY pengajuan_sementara.tgl_pengajuan DESC");

$query_get_nama_pengaju = mysqli_query($koneksi, "Select nama_lengkap from `user` where username='$_SESSION[username]'");
$nama_lengap_pengaju = mysqli_fetch_assoc($query_get_nama_pengaju)['nama_lengkap'];


$query = mysqli_query($koneksi, "	SELECT *, count(pengajuan.kode_brg) 
FROM  (pengajuan inner join pengajuan_sementara on pengajuan.id_pengajuan_sementara=pengajuan_sementara.id_pengajuan_sementara) 
WHERE pengajuan_sementara.unit='$nama_lengap_pengaju' and pengajuan_sementara.user_id='$_SESSION[user_id]' 
and !isnull(pengajuan_sementara.id_pengajuan_sementara) GROUP BY pengajuan_sementara.tgl_pengajuan DESC, 
pengajuan_sementara.status ");

?>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Data Pengajuaan Barang</h3>
                </div>
                <div class="box-body">
                    <a href="index.php?p=formpengajuan_table" style="margin:10px 15px;" class="btn btn-success">
                        <i class='fa fa-plus'>
                            Form Pengajuan Barang
                        </i>
                    </a>
                    <div class="table-responsive">
                        <table class="table text-center" id="datapengajuan_table_operator">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Pengajuan</th>
                                <th>User</th>
                                <th>Aksi</th>
                                <th>Cetak</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!--<tr>-->
                            <?php
                            $no = 1;
                            if (mysqli_num_rows($query)) {
                                while ($row = mysqli_fetch_assoc($query)) {

                                    ?>
                                    <tr>
                                        <td> <?= $no; ?> </td>
                                        <td> <?= tanggal_indo($row['tgl_pengajuan']); ?> </td>
                                        <td> <?= $row['unit']; ?> </td>

                                        <td>
                                            <?php

                                            if ($row['status_pengajuan'] != 'Input Pengajuan Ke Stok') {
                                                ?>
                                                <a href="?p=detilpengajuan_table&unit=<?= $row['unit']; ?>&tgl_pengajuan=<?= $row['tgl_pengajuan']; ?>&user_id=<?php echo $row['user_id']; ?>">
                           <span data-placement='top' data-toggle='tooltip' title='Input Barang Masuk'>
                               <button class="btn btn-info">Input Barang Masuk</button>
                           </span>
                                                </a>
                                                <?php
                                            } else if ($row['status_pengajuan'] = 'Input Pengajuan Ke Stok') { ?>
                                                <a href="#">
                           <span data-placement='top' data-toggle='tooltip' title='Jika Sudah Diinput Ke Stok Barang'>
                               <button class="btn btn-info">Sudah Diinput Ke Stok Baarang</button>
                           </span>
                                                </a>
                                            <?php }
                                            ?>

                                        </td>
                                        <td>
                                            <a target="_blank"
                                               href="cetakpengajuan_table.php?&tgl=<?= $row['tgl_pengajuan']; ?>&unit=<?= $row['unit']; ?>">
                                        <span data-placement='top' data-toggle='tooltip' title='Cetak'>
                                            <button class="btn btn-success">
                                                <i class="fa fa-print">
                                                    Cetak Pengajuan Barang
                                                </i>
                                            </button>
                                        </span>
                                            </a>

                                    </tr>

                                    <?php $no++;
                                }
                            } ?>

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
        $("#datapengajuan_table_operator").DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            }
        });
    });
</script>