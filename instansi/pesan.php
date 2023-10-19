<?php  

include "../fungsi/koneksi.php";
$tgl = date('Y-m-d');


//Ditambah Johan
//$sekarang = date('Y-m-d');
//$queryCekData = mysqli_query($koneksi,"SELECT sementara.unit,
//sementara.id_sementara, stokbarang.nama_brg, stokbarang.satuan, sementara.kode_brg,
//jumlah FROM sementara INNER JOIN
//stokbarang ON sementara.kode_brg  = stokbarang.kode_brg WHERE tgl_permintaan = '$sekarang'
//AND sementara.unit='$_SESSION[username]'");
//akhir dari yang ditambah johan

$query =  "INSERT INTO permintaan SELECT * FROM sementara";
$query2 = "DELETE FROM sementara WHERE tgl_permintaan='$tgl'";


//abaikan
if(mysqli_query($koneksi, $query)){
	mysqli_query($koneksi, $query2);
	echo '<script language="javascript">alert("From Permintaan Barang Berhasil Di Kirim !!!"); 
document.location="index.php?p=datapesanan";</script>';
} else {
	echo "gagal euy " . mysqli_error($koneksi);
}


?>