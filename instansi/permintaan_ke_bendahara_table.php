<?php
session_start();
include "../fungsi/koneksi.php";
include "../classes/class.phpmailer.php";

$tgl_sekarang = date('Y-m-d');

if(isset($_POST['permintaan_ke_bendahara'])){

    $id_sementara = $_POST['id_sementara'];
    $kode_brg = $_POST['kode_brg'];
    $id_jenis = $_POST['id_jenis'];
    $nama_brg = $_POST['nama_brg'];
    $satuan_brg = $_POST['satuan_brg'];
    $jumlah_brg = $_POST['jumlah_brg'];
    $status_acc_brg = $_POST['status_acc_brg'];
    $tgl_permintaan = $_POST['tgl_permintaan'];
    $status = $_POST['status'];

//    echo $id_sementara."-".$kode_brg.'-'.$nama_brg;
//    echo $_SESSION['username'];

    $query_cek_id_sementara_on_permintaan_table = mysqli_query($koneksi,"select * from permintaan where 
id_sementara='$id_sementara'");

    if((mysqli_num_rows($query_cek_id_sementara_on_permintaan_table)) <= 0){
        $query_update_sementara = mysqli_query($koneksi,"update sementara set status_acc='Pengajuan Bendahara'
where id_sementara='$id_sementara'");

        $query_insert_permintaan = mysqli_query($koneksi,"INSERT into permintaan
(unit, user_id, instansi, kode_brg, id_jenis, jumlah, tgl_permintaan, status, id_sementara)
VALUES	('$_SESSION[username]', '$_SESSION[user_id]', '$_SESSION[level]',
'$kode_brg', '$id_jenis', '$jumlah_brg','$tgl_permintaan', '$status','$id_sementara')");

        if($query_update_sementara && $query_insert_permintaan){
            echo "<script>window.alert('Permintaan Barang Berhasil Diajukan Ke Bendahara')
		window.location='index.php?p=detil_table&tgl=$tgl_permintaan'</script>";
        } else {
            echo "gagal euy cuy" . mysqli_error($koneksi);
        }
    } else {
        echo "<script>window.alert('Maaf Data Sudah Ada')
		window.location='index.php?p=detil_table&tgl=$tgl_permintaan'</script>";
    }


}



?>