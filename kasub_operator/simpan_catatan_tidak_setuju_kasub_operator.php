<?php

session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

if(isset($_POST['simpan_catatan_tidak_setuju_kasub_operator'])){
    $id_sementara = $_POST['id_sementara'];
    $unit = $_POST['unit'];
    $user_id = $_POST['user_id'];
    $tgl_permintaan = $_POST['tgl_permintaan'];

    $query_get_user_pemohon = mysqli_query($koneksi,"select * from user where id_user='$user_id'");
    $dt_unit_pemohon = mysqli_fetch_array($query_get_user_pemohon) ;
    $nama_unit_pemohon = $dt_unit_pemohon['username'];

    //metode taruh variabel di alert php I
    echo '<script language="javascript">alert("'.$nama_unit_pemohon." ".$user_id." ".$tgl_permintaan." ".'")';
//    echo "alert";
    echo '</script>';
    $catatan_tidak_setuju_kasub_operator = $_POST['catatan_tidak_setuju_kasub_operator'];
//    echo "<script>window.alert($unit)</script>";

//    echo $id_sementara."::";
//    echo $unit."::";
//    echo $user_id."::";
//    echo $tgl_permintaan."::";
//    echo $catatan_tidak_setuju_kasub_operator."::";

    $query_update = mysqli_query($koneksi,"update sementara set
note_kasub_operator='$catatan_tidak_setuju_kasub_operator',status_acc='Tidak Setuju Kasub Bendahara'
where id_sementara='$id_sementara'");


    if($query_update){
        //index.php?p=detilpermintaan&unit=Undar&user_id=23&tgl_permintaan=2022-10-29
//        echo "<script>window.alert('Berhasil Simpan Note')
//		window.location='index.php?p=detilpermintaan_table&unit=$_POST[unit]&user_id=$_POST[user_id]&tgl_permintaan=$_POST[tgl_permintaan]'</script>";

        echo "<script>window.alert('Berhasil Simpan Note')
		window.location='index.php?p=detilpermintaan_table&unit=$nama_unit_pemohon&user_id=$_POST[user_id]&tgl_permintaan=$_POST[tgl_permintaan]'</script>";

    } else {
        echo "gagal euy cuy" . mysqli_error($koneksi);
    }

}

?>