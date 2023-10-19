<?php
session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

$id_pengajuan_sementara = isset($_POST['id_pengajuan_sementara'])? $_POST['id_pengajuan_sementara']:'';
$id_pengajuan = isset($_POST['id_pengajuan'])? $_POST['id_pengajuan']:'';
$tanggal_masuk= date('Y-m-d');

echo $id_pengajuan_sementara.'::';
echo $id_pengajuan.'::';

$query_get_data = mysqli_query($koneksi,"select * from pengajuan_sementara INNER JOIN pengajuan on 
pengajuan_sementara.id_pengajuan_sementara=pengajuan.id_pengajuan_sementara 
where pengajuan_sementara.id_pengajuan_sementara='$id_pengajuan_sementara'");

$item = mysqli_fetch_assoc($query_get_data);

echo $item['kode_brg']."::";
echo $item['jumlah']."::";
echo $item['tgl_pengajuan']."tgl_pengajuan::";
echo $tanggal_masuk."::";

$query_get_data_tb_stokbarang = mysqli_query($koneksi,"select * from stokbarang where kode_brg='$item[kode_brg]'");

$item_stok = mysqli_fetch_assoc($query_get_data_tb_stokbarang);

echo $item_stok['stok']."::";

$updated_stok = intval($item_stok['stok']+$item['jumlah']);
$updated_sisa = intval($item_stok['sisa']+$item['jumlah']);
echo $updated_stok."::";
echo $updated_sisa."::";



if(isset($_POST['id_pengajuan_sementara']) && isset($_POST['id_pengajuan'])){

    $query_update_status_boolean_tb_pengajuan_sementara = mysqli_query($koneksi,"update pengajuan_sementara set
status='1',status_pengajuan='Input Pengajuan Ke Stok' where id_pengajuan_sementara='$id_pengajuan_sementara'");

    $query_update_status_boolean_tb_pengajuan = mysqli_query($koneksi,"update pengajuan set status='1'
where id_pengajuan_sementara='$id_pengajuan_sementara'");

    $query_insert_into_tb_pemasukan = mysqli_query($koneksi,"insert into pemasukan
(unit,kode_brg,jumlah,tgl_masuk,id_pengajuan_sementara)
values('$_SESSION[username]','$item[kode_brg]','$item[jumlah]','$tanggal_masuk','$id_pengajuan_sementara')");

    $query_update_jumlahbrg_on_tb_stokbarang = mysqli_query($koneksi,"update stokbarang set stok='$updated_stok',
sisa='$updated_sisa' where kode_brg='$item[kode_brg]'");

    if($query_update_status_boolean_tb_pengajuan_sementara && $query_update_status_boolean_tb_pengajuan && $query_insert_into_tb_pemasukan && $query_update_jumlahbrg_on_tb_stokbarang){
        //index.php?p=detilpengajuan&unit=Sinar&tgl_pengajuan=2022-11-04&user_id=21
        echo "<script>window.alert('Barang Telah Dimasukkan Ke Stok Barang, Terimakasih!!')
		window.location='index.php?p=detilpengajuan_table&unit=$_SESSION[username]&tgl_pengajuan=$item[tgl_pengajuan]&user_id=$_SESSION[user_id]'</script>";
    } else {
        echo "gagal euy cuy" . mysqli_error($koneksi);
    }
}


?>