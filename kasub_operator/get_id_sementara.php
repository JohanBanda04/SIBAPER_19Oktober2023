<?php
session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";


$id_sementara = isset($_POST['id_sementara'])? $_POST['id_sementara']:'';

$unit = isset($_POST['unit'])? $_POST['unit']:'';
$user_id = isset($_POST['user_id'])? $_POST['user_id']:'';
$tgl_permintaan = isset($_POST['tgl_permintaan'])? $_POST['tgl_permintaan']:'';

//        index.php?p=detilpermintaan&unit=Undar&user_id=23&tgl_permintaan=2022-10-19
header("location:index.php?p=detilpermintaan&unit=$unit&user_id=$user_id&tgl_permintaan=$tgl_permintaan");

//if(isset($_GET['id_sementara'])){
//    $id_sementara = $_GET['id_sementara'];
//    $unit = $_GET['unit'];
//    $user_id = $_GET['user_id'];
//    $tgl_permintaan = $_GET['tgl_permintaan'];
//
//    echo $id_sementara.'::';
//    echo $user_id.'::';
//    echo $unit.'::';
//    echo $tgl_permintaan;
//
//    $query = mysqli_query($koneksi,"UPDATE sementara SET acc_kasub=1,
//status_acc='Setuju Kasub Bendahara' WHERE id_sementara='$id_sementara'");
//
//    if($query){
////        mengacu dari kebutuhan parameter get utk halaman detilpermintaan.php seperti dibawah :
////        p=detilpermintaan&unit=Undar&user_id=23&tgl_permintaan=2022-10-04
////        p=detilpermintaan&unit=Bela&user_id=26&tgl_permintaan=2022-10-10
//
//        header("location:index.php?p=detilpermintaan&unit=$unit&user_id=$user_id&tgl_permintaan=$tgl_permintaan");
//    } else {
//        echo "ada yang salah" . mysqli_error($koneksi);
//    }
//}




?>

