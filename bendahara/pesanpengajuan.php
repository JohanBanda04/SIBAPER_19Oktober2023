<?php  

include "../fungsi/koneksi.php";
$tgl = date('Y-m-d');

//echo "Buat Pengajuan Permintaan Baru Barang";

//$query =  "INSERT INTO pengajuan SELECT * FROM pengajuan_sementara";
//$query2 = "DELETE FROM pengajuan_sementara WHERE tgl_pengajuan='$tgl'";


//$queryJenis_bk = mysqli_query($koneksi, "UPDATE sementara set status_acc='Pengajuan Kasub' where
//id_subbidang=$_SESSION[subbidang_id] and user_id=$_SESSION[user_id] and status_acc='Permintaan Baru'");
//
//$queryJenis = mysqli_query($koneksi, "UPDATE pengajuan_sementara set status_acc='Pengajuan Kasub' where
//id_subbidang=$_SESSION[subbidang_id] and user_id=$_SESSION[user_id] and status_acc='Permintaan Baru'");


if(mysqli_query($koneksi, $query)){
	mysqli_query($koneksi, $query2);
	echo '<script language="javascript">alert("Form Pengajuan Berhasil Di Buat  !!!"); document.location="index.php?p=datapengajuan";</script>';
} else {
	echo "gagal euy" . mysqli_error($koneksi);
}


?>