<?php
include "../fungsi/koneksi.php";

if(isset($_GET['id'])){
	$id=$_GET['id'];

	$query = mysqli_query($koneksi,"delete from stokbarang where kode_brg='$id'");
	if ($query) {
		echo '<script language="javascript">alert("Data Berhasil Di Hapus !!!"); document.location="index.php?p=material-m3&id_jenis=3";</script>';
	} else {
		echo 'gagal';
	}
	
}
?>