<?php
//
//include "../fungsi/koneksi.php";
//
//if (isset($_GET['id_sementara']) && isset($_GET['unit']) && isset($_GET['tgl'])) {
//    $id_sementara = $_GET['id_sementara'];
//    $unit = $_GET['unit'];
//    $tgl = $_GET['tgl'];
//    $status_acc = $_GET['status_acc'];
//
//    $tanggal = date('Y-m-d');
//
//
//    $query1 = mysqli_query($koneksi, "UPDATE sementara SET acc_kasub=0, status_acc='$status_acc'  WHERE id_sementara='$id_sementara' ");
////
//
//
//    if ($query1) {
////        header("location:index.php?p=datapermintaan&tgl=$tgl&unit=$unit");
//        header("location:index.php?p=detilpermintaan&unit=$unit&tgl=$tgl");
//    } else {
//        echo "ada yang salah" . mysqli_error($koneksi);
//    }
//
//
//
//}
//
//
//?>


<!--baru-->
<?php
session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

if(isset($_GET['id_sementara'])){
    $id_sementara = $_GET['id_sementara'];
    $unit = $_GET['unit'];
    $user_id = $_GET['user_id'];
    $tgl_permintaan = $_GET['tgl_permintaan'];

    echo $id_sementara.'-';
    echo $user_id.'-';
    echo $unit.'-';
    echo $tgl_permintaan;

    $query = mysqli_query($koneksi,"UPDATE sementara SET acc_kasub=1,
status_acc='tidak_setuju' WHERE id_sementara='$id_sementara'");

    if($query){
//        mengacu dari kebutuhan parameter get utk halaman detilpermintaan.php seperti dibawah :
//        p=detilpermintaan&unit=Undar&user_id=23&tgl_permintaan=2022-10-04
        header("location:index.php?p=detilpermintaan&unit=$unit&user_id=$user_id&tgl_permintaan=$tgl_permintaan");
    } else {
        echo "ada yang salah" . mysqli_error($koneksi);
    }
}




?>



