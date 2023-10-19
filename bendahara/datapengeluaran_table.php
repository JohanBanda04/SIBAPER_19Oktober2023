<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

if (isset($_GET['aksi']) && isset($_GET['tgl'])) {
    //die($id = $_GET['id']);
    $tgl = $_GET['tgl'];
    echo $tgl;


}
if (isset($_GET['aksi']) && isset($_GET['unit'])) {
    $aksi = $_GET['aksi'];
    $unit = $_GET['unit'];
    if ($aksi == 'hapus') {
        $query2 = mysqli_query($koneksi, "DELETE FROM permintaan WHERE unit='$unit' ");
        if ($query2) {
            header("location:?p=datapengeluaran&tgl=" . $tgl);
        } else {
            echo 'gagal';
        }
    }
}


$query_old = mysqli_query($koneksi, "SELECT distinct(unit), instansi, tgl_permintaan FROM permintaan WHERE  status=1");
$query = mysqli_query($koneksi, "SELECT distinct(unit),user_id, instansi, tgl_permintaan FROM permintaan WHERE  status=1 order by tgl_permintaan desc");


?>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Data Permintaan Barang Keluarr</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center" id="datapengeluaran_side_operator">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Permintaan</th>
                                <th>Nama</th>
                                <th>Intansi</th>
                                <th>Detail</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!--                            <tr>-->
                            <?php
                            $no = 1;
                            if (mysqli_num_rows($query)) {
                                while ($row = mysqli_fetch_assoc($query)){

                                    ?>
                                    <tr>
                                        <td> <?= $no; ?> </td>
                                        <td> <?= tanggal_indo($row['tgl_permintaan']); ?> </td>
                                        <td> <?php
                                            $query_get_nama_pemohon = mysqli_query($koneksi, "Select nama_lengkap from `user` where id_user='$row[user_id]'");
                                            echo mysqli_fetch_assoc($query_get_nama_pemohon)['nama_lengkap'];
                                            ?>
                                        </td>
                                        <td> <?= $row['instansi']; ?> </td>

                                        <td>
                                            <?php
//                                            $ciphering = "BF-CBC";
//                                            $encryption_iv = random_bytes($iv_length);
//                                            $encryption_key = openssl_digest(php_uname(), 'MD5', TRUE);
//                                            $options = 0;
                                            ?>
                                            <a href="?p=detil_datapengeluaran_table&unit=<?= $row['unit']; ?>&tgl=<?= $row['tgl_permintaan']; ?>&user_id=<?php echo $row['user_id']; ?>">
                                        <span data-placement='top' data-toggle='tooltip' title='Detail Permintaan'>
                                            <button class="btn btn-info">Detail Barang</button>
                                        </span>
                                            </a>

                                        </td>
                                        <td>

                                            <a href="?p=datapengeluaran&aksi=hapus&unit=<?= $row['unit']; ?>&tgl=<?= $row['tgl_permintaan']; ?>"><span
                                                        data-placement='top' data-toggle='tooltip' title='Hapus'><button
                                                            class="btn btn-danger"
                                                            onclick="return confirm('Yakin ingin menghapus ?')">Hapus</button></span></a>

                                        </td>
                                    </tr>
                                    <?php $no++; }
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
        $("#datapengeluaran_side_operator").DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            }
        });
    });
</script>