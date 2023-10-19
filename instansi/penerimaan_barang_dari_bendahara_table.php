<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";
//echo "tes"."::";


//metode pengganti untuk post yang terhidden
$id_sementara = $_POST['id_sementara'];
echo $id_sementara . "::<br>";

$query_get_kode_brg = mysqli_query($koneksi, "select sementara.unit, sementara.user_id,sementara.kode_brg,
sementara.jumlah,sementara.id_sementara, sementara.tgl_permintaan,sementara.bendahara_id,stokbarang.stok,
stokbarang.keluar,stokbarang.sisa
from (sementara inner join stokbarang on sementara.kode_brg=stokbarang.kode_brg) where id_sementara='$_POST[id_sementara]'");
$dt_get_kode_brg = mysqli_fetch_assoc($query_get_kode_brg);
//    echo $dt_get_kode_brg['unit']."::<br>";
//    echo $dt_get_kode_brg['user_id']."::<br>";
//    echo $dt_get_kode_brg['kode_brg']."::<br>";
//    echo $dt_get_kode_brg['jumlah']."::<br>";
//    echo $dt_get_kode_brg['id_sementara']."::<br>";
//    echo $dt_get_kode_brg['tgl_permintaan']."::<br>";
//    echo $dt_get_kode_brg['bendahara_id']."::<br>";

$dt_unit = $dt_get_kode_brg['unit'];
$dt_user_id = $dt_get_kode_brg['user_id'];
$dt_kode_brg = $dt_get_kode_brg['kode_brg'];
$dt_jumlah = $dt_get_kode_brg['jumlah'];
$dt_id_sementara = $dt_get_kode_brg['id_sementara'];
$dt_tgl_permintaan = $dt_get_kode_brg['tgl_permintaan'];
$dt_bendahara_id = $dt_get_kode_brg['bendahara_id'];

$tgl_keluar = date("Y-m-d");

$dt_old_stok = $dt_get_kode_brg['stok'];
$dt_old_sisa = $dt_get_kode_brg['sisa'];
$dt_old_keluar = $dt_get_kode_brg['keluar'];

$dt_new_sisa = $dt_old_sisa - $dt_jumlah;
$dt_new_keluar = $dt_old_keluar + $dt_jumlah;

//echo $dt_unit . "<br>";
//echo $dt_user_id . "<br>";
//echo $dt_kode_brg . "<br>";
//echo $dt_jumlah . "<br>";
//echo $dt_id_sementara . "<br>";
//echo $dt_tgl_permintaan . "<br>";
//echo $dt_bendahara_id . "<br>";
//
//echo $tgl_keluar . "<br>";
//
//echo $dt_old_stok . "<br>";
//echo $dt_old_sisa . "<br>";
//echo $dt_old_keluar . "<br>";
//echo $dt_new_sisa . "<br>";
//echo $dt_new_keluar . "<br>";


$cek_id_sementara_on_pengeluaran = mysqli_query($koneksi, "select * from pengeluaran where id_sementara='$_POST[id_sementara]'");

if(mysqli_num_rows($cek_id_sementara_on_pengeluaran) <= 0){
    if(isset($_POST['penerimaan_barang_dari_bendahara']) && isset($_POST['id_sementara'])){

        //disini melibatkan 3 tabel yakni tabel sementara , tabel pengeluaran, dan tabel stokbarang
        $query_update_terima_dari_bendahara = mysqli_query($koneksi, "UPDATE sementara 
set status_acc='Penerimaan Barang Dari Bendahara'
where id_sementara='$dt_id_sementara'");

        $query_insert_pengeluaran = mysqli_query($koneksi, "INSERT into pengeluaran 
(unit, user_id, kode_brg, jumlah, tgl_keluar, id_sementara)
VALUES ('$dt_unit', '$dt_user_id', '$dt_kode_brg', 
'$dt_jumlah', '$tgl_keluar', '$dt_id_sementara')");

        $query_update_tb_stokbarang = mysqli_query($koneksi,"UPDATE stokbarang set keluar='$dt_new_keluar',
sisa='$dt_new_sisa' where kode_brg='$dt_kode_brg'");

        if($query_update_terima_dari_bendahara && $query_insert_pengeluaran && $query_update_tb_stokbarang){
            echo "<script>window.alert('Penerimaan Barang Sudah Terkonfirmasi, Terimakasih Banyak!!')
		window.location=
		'index.php?p=detil_history_permintaan_barang_table&unit=$dt_unit&user_id=$dt_user_id&tgl_permintaan=$dt_tgl_permintaan&kode_brg_lengkap='</script>";
        } else {
            echo "gagal euy cuy" . mysqli_error($koneksi);
        }
    }
} else if(mysqli_num_rows($cek_id_sementara_on_pengeluaran) > 0) {
    echo "<script>window.alert('Maaf Data Sudah Terdaftar Pada Pengeluaran')
		window.location='index.php?p=detil_history_permintaan_barang_table&unit=$dt_unit&user_id=$dt_user_id&tgl_permintaan=$dt_tgl_permintaan'</script>";
}
//
////CEK DISINI BRO
//$id_sementara = isset($_POST['id_sementara'])? $_POST['id_sementara']:'';
//$unit = isset($_POST['unit'])? $_POST['unit']:'';
//$tgl_permintaan = isset($_POST['tgl_permintaan'])? $_POST['tgl_permintaan']:'';
//$user_id = isset($_POST['user_id'])? $_POST['user_id']:'';
//$bendahara_id = isset($_POST['bendahara_id'])? $_POST['bendahara_id']:'';
//$kode_brg = isset($_POST['kode_brg'])? $_POST['kode_brg']:'';
//$jumlah = isset($_POST['jumlah'])? $_POST['jumlah']:'';
////tgl_keluar = sekarang
//$tgl_keluar = date('Y-m-d');
//
//$query_get_stokbarang = mysqli_query($koneksi,"select * from stokbarang where kode_brg='$kode_brg'");
//while ($data = mysqli_fetch_array($query_get_stokbarang)){
//    $old_stok = $data['stok'];
//    $new_stok = intval($data['stok'])-intval($jumlah);
//
//    $keluar = $data['keluar'];
//    $new_keluar = intval($data['keluar'])+intval($jumlah);
//
//    $sisa = $data['sisa'];
//    $new_sisa = intval($data['sisa'])-intval($jumlah);
//}
//
//
////metode pengecekan data record
//$cek_id_sementara_on_pengeluaran = mysqli_query($koneksi,"select * from pengeluaran where id_sementara='$id_sementara'");
//


//if(mysqli_num_rows($cek_id_sementara_on_pengeluaran) <= 0){
//    if (isset($_POST['penerimaan_barang_dari_bendahara']) && isset($_POST['id_sementara'])) {
//
//        $query_update_terima_dari_bendahara = mysqli_query($koneksi, "UPDATE sementara
//set status_acc='Penerimaan Barang Dari Bendahara'
//where id_sementara='$id_sementara'");
//
//
//        $query_insert_pengeluaran = mysqli_query($koneksi, "INSERT into pengeluaran
//(unit, user_id, kode_brg, jumlah, tgl_keluar, id_sementara)
//VALUES ('$_POST[unit]', '$_POST[user_id]', '$_POST[kode_brg]',
//'$_POST[jumlah]', '$tgl_keluar', '$_POST[id_sementara]')");
//
//
//
//        //hati-hati dan ingat bahwa yg di update hanya kolom keluar dan sisa barang pada tabel 'stokbarang' ini
//        $query_update_tb_stokbarang = mysqli_query($koneksi,"UPDATE stokbarang set keluar='$new_keluar',
//sisa='$new_sisa' where kode_brg='$kode_brg'");
//
//        if ($query_update_terima_dari_bendahara && $query_insert_pengeluaran && $query_update_tb_stokbarang) {
////        index.php?p=detil_history_permintaan_barang&unit=Undar&user_id=23&tgl_permintaan=2022-10-19
//            echo "<script>window.alert('Penerimaan Barang Sudah Terkonfirmasi, Terimakasih Banyak!!')
//		window.location='index.php?p=detil_history_permintaan_barang_table&unit=$_POST[unit]&user_id=$_POST[user_id]&tgl_permintaan=$_POST[tgl_permintaan]'</script>";
//        } else {
//            echo "gagal euy cuy" . mysqli_error($koneksi);
//        }
//    }
//} else if(mysqli_num_rows($cek_id_sementara_on_pengeluaran) > 0) {
//    //index.php?p=detil_history_permintaan_barang&unit=Undar&user_id=23&tgl_permintaan=2022-10-31
//    echo "<script>window.alert('Maaf Data Sudah Terdaftar Pada Pengeluaran')
//		window.location='index.php?p=detil_history_permintaan_barang_table&unit=$_POST[unit]&user_id=$_POST[user_id]&tgl_permintaan=$_POST[tgl_permintaan]'</script>";
//}


?>