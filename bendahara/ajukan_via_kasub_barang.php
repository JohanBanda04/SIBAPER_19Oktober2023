<?php

session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

$unit_pemohon = $_GET['unit'];
$id_sementara = $_GET['id_sementara'];
$tgl_permintaan = $_GET['tgl_permintaan'];
$user_id_pemohon = $_GET['user_id_pemohon'];
$bendahara_id = $_GET['bendahara_id']??'';


//echo $unit_pemohon.'::';
//echo $id_sementara.'::';
//echo $tgl_permintaan.'::';
//echo $user_id_pemohon.'::';
//echo $bendahara_id.'::';

$cek_bendahara = mysqli_query($koneksi,"select * from sementara where id_sementara='$id_sementara'");

if(mysqli_num_rows($cek_bendahara) > 0){
//    echo "ada data record";
    while ($dts = mysqli_fetch_array($cek_bendahara)){
//        echo $dts['bendahara_id'];
        if($dts['bendahara_id']=='' || $dts['bendahara_id']==null){
//            echo "Belum ada bendahara_id yang memproses permintaan ini";
            $query = mysqli_query($koneksi,"update sementara set status_acc='Pengajuan Kasub Bendahara',
bendahara='$_SESSION[username]',bendahara_id='$_SESSION[user_id]'
where id_sementara='$id_sementara'");


            if($query){
                echo "<script>window.alert('Permintaan Barang Berhasil Diajukan Ke Kasub Bendahara')
		window.location='index.php?p=detilpermintaan&unit=$unit_pemohon&tgl=$tgl_permintaan&user_id_pemohon=$user_id_pemohon&bendahara_id=$bendahara_id'</script>";
            } else {
                echo "gagal euy cuy" . mysqli_error($koneksi);
            }
        } else {
//            echo "Sudah ada bendahara_id lain yang memproses permintaan ini";
            //sudah ada bendahara nya, maka lakukan pengecekan apakah nama yg sudah ada sama dengan session username yg login

            $queries = mysqli_query($koneksi,"select * from sementara where id_sementara='$id_sementara'");
            $item = mysqli_fetch_assoc($queries);
//            echo $item['bendahara'];
            if(ucfirst($_SESSION['username'])==$item['bendahara']){
//                echo "nama bendahara sama";
                $query_after_ada_edit_dari_bendahara = mysqli_query($koneksi,"update sementara set status_acc='Pengajuan Kasub Bendahara',
bendahara='$_SESSION[username]',bendahara_id='$_SESSION[user_id]'
where id_sementara='$id_sementara'");


                if($query_after_ada_edit_dari_bendahara){
                    echo "<script>window.alert('Permintaan Barang Berhasil Diajukan Ke Kasub Bendahara')
		window.location='index.php?p=detilpermintaan&unit=$unit_pemohon&tgl=$tgl_permintaan&user_id_pemohon=$user_id_pemohon&bendahara_id=$bendahara_id'</script>";
                } else {
                    echo "gagal euy cuy" . mysqli_error($koneksi);
                }
            } else {
//                echo "nama bendahara tidak sama";
                echo "<script>window.alert('Maaf, Sudah Ada Bendahara Lain Yang Memproses Permintaan Ini')
		window.location='index.php?p=detilpermintaan&unit=$unit_pemohon&tgl=$tgl_permintaan&user_id_pemohon=$user_id_pemohon&bendahara_id=$bendahara_id'</script>";
            }

//            echo "<script>window.alert('Maaf, Sudah Ada Bendahara Lain Yang Memproses Permintaan Ini')
//		window.location='index.php?p=detilpermintaan&unit=$unit_pemohon&tgl=$tgl_permintaan&user_id_pemohon=$user_id_pemohon&bendahara_id=$bendahara_id'</script>";
        }
    }
} else {
    echo "tdk ada data record dgn id_sementara tersebut euy";
}

?>