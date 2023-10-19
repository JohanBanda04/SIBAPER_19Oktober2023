<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

if (isset($_GET['tgl']) && isset($_GET['unit'])) {
    $tgl = $_GET['tgl'];
    $unit = $_GET['unit'];


    $query_old = mysqli_query($koneksi, "SELECT permintaan.tgl_permintaan, permintaan.id_permintaan, 
permintaan.kode_brg, nama_brg, jumlah, satuan, status,unit FROM permintaan INNER JOIN 
        stokbarang ON permintaan.kode_brg = stokbarang.kode_brg  
        WHERE tgl_permintaan='$tgl' AND unit='$unit' AND status!=1");

    $query = mysqli_query($koneksi, "SELECT sementara.unit,  
sementara.id_sementara, stokbarang.nama_brg, stokbarang.satuan, sementara.kode_brg, sementara.tgl_permintaan ,
sementara.pemberitahuan_kasub, sementara.acc_kasub,sementara.status_acc,
jumlah FROM sementara INNER JOIN 
stokbarang ON sementara.kode_brg  = stokbarang.kode_brg WHERE sementara.id_subbidang='$_SESSION[subbidang_id]' 
and status_acc !='Permintaan Baru' and status_acc !='Pengajuan Kasub' and tgl_permintaan='$tgl'");





}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'edit')
        header("location:?p=editpesan");
}

?>
<!--disini dicek johan-->
<?php //echo $tgl?><!--ss </br>-->
<?php //echo $unit?>
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Konfirmasi Permintaan  <?php echo $unit; ?></h3>
                </div>
                <div class="box-body">
                    <a href="index.php?p=history_kasub" style="margin:10px;" class="btn btn-success"><i class='fa fa-backward'>  Kembali</i></a>
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead  >
                            <tr>
                                <th>No</th>
                                <th>Id Permintaan</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <?php
                                $no =1 ;
                                if (mysqli_num_rows($query)) {
                                while($row=mysqli_fetch_assoc($query)):

                                ?>
                                <td> <?= $no; ?> </td>
                                <td> <?= $row['id_sementara']; ?> </td>
                                <td> <?= $row['kode_brg']; ?> </td>
                                <td> <?= $row['nama_brg']; ?> </td>
                                <td> <?= $row['satuan']; ?> </td>
                                <td> <?= $row['jumlah']; ?> </td>
                                <td >
                                    <span class="text-primary">
                                        <?= $row['status_acc']?>
                                    </span>
<!--                                    --><?php
//                                    if ($row['status'] == 0){
//                                        echo '<span class=text-warning>$row["status_acc"]</span>';
//                                    } elseif ($row['status'] == 1) {
//                                        echo '<span class=text-primary>Telah Disetujui</span>';
//                                    } else {
//                                        echo '<span class=text-danger>Tidak Disetujui</span>';
//                                    }
//                                    ?>
                                </td>

                            </tr>

                            <?php $no++; endwhile; }else {echo "<tr><td colspan=9>Tidak ada permintaan material teknik.</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

