<?php

include "../fungsi/koneksi.php";
$tgl = date('Y-m-d');

//Tambahan dari johan untuk proses minta barang jika belum ada barang pesanan
//$query =  "INSERT INTO permintaan SELECT * FROM sementara";
//$query2 = "DELETE FROM sementara WHERE tgl_permintaan='$tgl'";

echo '<script language="javascript">alert("Anda Belum Memilih Barang"); document.location="index.php?p=formpesan";</script>';




?>