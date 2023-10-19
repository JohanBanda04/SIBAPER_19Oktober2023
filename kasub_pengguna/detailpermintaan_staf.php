<?php
//session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";
$tgl_sekarang = date('Y-m-d');


if(isset($_POST['detail_permintaan'])){
    $unit = $_POST['unit'];
    $user_id_staf_pemohon = $_POST['user_id_staf_pemohon'];
    $instansi = $_POST['instansi'];
    $tgl_permintaan = $_POST['tgl_permintaan'];

//    echo $tgl_permintaan;
//    echo $unit;

    $query = mysqli_query($koneksi, "SELECT sementara.tgl_permintaan, sementara.id_sementara, 
sementara.kode_brg,sementara.acc_kasub, nama_brg, jumlah, satuan, status,unit, sementara.status_acc FROM sementara 
INNER JOIN stokbarang ON sementara.kode_brg = stokbarang.kode_brg  
        WHERE tgl_permintaan='$tgl_permintaan' AND unit='$unit' AND user_id='$user_id_staf_pemohon' AND status!=1");
//filter status_acc='Pengajuan Kasub' yg sebelumnya ada dihilangkan

}

?>
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Konfirmasi Permintaan <?php echo $unit?></h3>
                </div>
            </div>
        </div>
    </div>
</section>





