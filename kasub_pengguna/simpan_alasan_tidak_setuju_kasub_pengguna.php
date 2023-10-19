<?php

session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

if(isset($_POST['simpan_catatan_tidak_setuju'])){
    $id_sementara = $_POST['id_sementara'];
    $unit = $_POST['unit'];
    $user_id = $_POST['user_id'];
    $tgl_permintaan = $_POST['tgl_permintaan'];

    $catatan_tidak_setuju_kasub_pengguna = $_POST['catatan_tidak_setuju_kasub_pengguna'];

//    echo $id_sementara."::";
//    echo $catatan_tidak_setuju_kasub_pengguna."::";
//    echo $unit."::";
//    echo $user_id."::";
//    echo $tgl_permintaan."::";

    $query_update = mysqli_query($koneksi,"update sementara set
note_kasub_pengguna='$catatan_tidak_setuju_kasub_pengguna',status_acc='tidak_setuju'
where id_sementara='$id_sementara'");

//    if($query){
//        //index.php?p=detilpermintaan&unit=Undar&user_id=23&tgl_permintaan=2022-10-29
//        echo "<script>window.alert('Data Note Berhasil Disimpan');
//		window.location='index.php?p=detilpermintaan&unit='$_POST[unit]'&user_id='$_POST[user_id]'&tgl_permintaan='$_POST[tgl_permintaan]'</script>";
//    } else {
//        echo "gagal euy cuy" . mysqli_error($koneksi);
//    }

    if($query_update){
        //index.php?p=detilpermintaan&unit=Undar&user_id=23&tgl_permintaan=2022-10-29
        echo "<script>window.alert('Berhasil Simpan Note')
		window.location='index.php?p=detilpermintaan&unit=$_POST[unit]&user_id=$_POST[user_id]&tgl_permintaan=$_POST[tgl_permintaan]'</script>";

    } else {
        echo "gagal euy cuy" . mysqli_error($koneksi);
    }

}

?>