<?php

include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

$id_sementara = isset($_POST['id_sementara'])? $_POST['id_sementara']:'';
$unit = isset($_POST['unit'])? $_POST['unit']:'';
$tgl_permintaan = isset($_POST['tgl_permintaan'])? $_POST['tgl_permintaan']:'';
$user_id = isset($_POST['user_id'])? $_POST['user_id']:'';
$bendahara_id = isset($_POST['bendahara_id'])? $_POST['bendahara_id']:'';
$kode_brg = isset($_POST['kode_brg'])? $_POST['kode_brg']:'';
$jumlah = isset($_POST['jumlah'])? $_POST['jumlah']:'';
//tgl_keluar = sekarang
$tgl_keluar = date('Y-m-d');

$query_get_stokbarang = mysqli_query($koneksi,"select * from stokbarang where kode_brg='$kode_brg'");
while ($data = mysqli_fetch_array($query_get_stokbarang)){
    $old_stok = $data['stok'];
    $new_stok = intval($data['stok'])-intval($jumlah);

    $keluar = $data['keluar'];
    $new_keluar = intval($data['keluar'])+intval($jumlah);

    $sisa = $data['sisa'];
    $new_sisa = intval($data['sisa'])-intval($jumlah);
}
//echo $old_stok."::";
//echo $keluar."::";
//echo $sisa."::";
//
//echo "new::";
//echo $new_stok."::";
//echo $new_keluar."::";
//echo $new_sisa."::";

//unit
//user_id
//kode_brg
//jumlah
//tgl_keluar
//id_sementara

//ngecek disini

//echo $unit."::";
//echo $user_id."::";
//echo $kode_brg."::";
//echo $jumlah."::";
//echo $tgl_keluar."::";
//echo $id_sementara."::";

//echo $tgl_permintaan."::";
//echo $bendahara_id."::";

//metode pengecekan data record
$cek_id_sementara_on_pengeluaran = mysqli_query($koneksi,"select * from pengeluaran where id_sementara='$id_sementara'");

if(mysqli_num_rows($cek_id_sementara_on_pengeluaran) <= 0){
    if (isset($_POST['penerimaan_barang_dari_bendahara']) && isset($_POST['id_sementara'])) {

        $query_update_terima_dari_bendahara = mysqli_query($koneksi, "UPDATE sementara set status_acc='Penerimaan Barang Dari Bendahara'
where id_sementara='$id_sementara'");


        $query_insert_pengeluaran = mysqli_query($koneksi, "INSERT into pengeluaran (unit, user_id, kode_brg, jumlah, tgl_keluar, id_sementara)
VALUES ('$_POST[unit]', '$_POST[user_id]', '$_POST[kode_brg]', '$_POST[jumlah]', '$tgl_keluar', '$_POST[id_sementara]')");

        //darisini
//        $query_get_stokbarang = mysqli_query($koneksi, "select * from stokbarang where kode_brg='$kode_brg'");
//        while ($data = mysqli_fetch_array($query_get_stokbarang)) {
//            $old_stok = $data['stok'];
//            $new_stok = ($data['stok']) - ($jumlah);
//
//            $keluar = $data['keluar'];
//            $new_keluar = ($data['keluar']) + ($jumlah);
//
//            $sisa = $data['sisa'];
//            $new_sisa = ($data['sisa']) - ($jumlah);
//        }

        //hati-hati dan ingat bahwa yg di update hanya kolom keluar dan sisa barang pada tabel 'stokbarang' ini
        $query_update_tb_stokbarang = mysqli_query($koneksi,"UPDATE stokbarang set keluar='$new_keluar',
sisa='$new_sisa' where kode_brg='$kode_brg'");

        if ($query_update_terima_dari_bendahara && $query_insert_pengeluaran && $query_update_tb_stokbarang) {
//        index.php?p=detil_history_permintaan_barang&unit=Undar&user_id=23&tgl_permintaan=2022-10-19
            echo "<script>window.alert('Penerimaan Barang Sudah Terkonfirmasi, Terimakasih!!')
		window.location='index.php?p=detil_history_permintaan_barang&unit=$_POST[unit]&user_id=$_POST[user_id]&tgl_permintaan=$_POST[tgl_permintaan]'</script>";
        } else {
            echo "gagal euy cuy" . mysqli_error($koneksi);
        }
    }
} else if(mysqli_num_rows($cek_id_sementara_on_pengeluaran) > 0) {
    //index.php?p=detil_history_permintaan_barang&unit=Undar&user_id=23&tgl_permintaan=2022-10-31
    echo "<script>window.alert('Maaf Data Sudah Terdaftar Pada Pengeluaran')
		window.location='index.php?p=detil_history_permintaan_barang&unit=$_POST[unit]&user_id=$_POST[user_id]&tgl_permintaan=$_POST[tgl_permintaan]'</script>";
}



?>