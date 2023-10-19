<?php

session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

$set_post_button = false;

if(isset($_POST['penyerahan_barang_pengguna']) && isset($_POST['id_sementara'])){

    $unit = $_POST['unit'];
    $tgl = $_POST['tgl_permintaan'];
    $user_id_pemohon = $_POST['user_id'];
    $bendahara_id = $_POST['bendahara_id'];

    $bendahara = $_POST['bendahara'];
    $id_sementara = $_POST['id_sementara'];

//    echo $user_id_pemohon."::";
//    echo $unit."::";
//    echo $tgl."::";
//    echo $bendahara_id."::";
//    echo $bendahara."::";
//    echo $id_sementara."::";
    //sampai disini sukses



    $query_update_serah_ke_pengguna = mysqli_query($koneksi,"update sementara set
status_acc='Penyerahan Barang Ke Pengguna'
where id_sementara='$id_sementara'");

    if($query_update_serah_ke_pengguna){
        //index.php?p=detilpermintaan&unit=Undar&tgl=2022-10-19&user_id_pemohon=23&bendahara_id=31
        echo "<script>window.alert('Silakan serahkan barang ke Pengguna')
		window.location='index.php?p=detilpermintaan_table&unit=$_POST[unit]&tgl=$_POST[tgl_permintaan]&user_id_pemohon=$_POST[user_id]&bendahara_id=$_POST[bendahara_id]'</script>";

    } else {
        echo "gagal euy cuy" . mysqli_error($koneksi);
    }

}

?>