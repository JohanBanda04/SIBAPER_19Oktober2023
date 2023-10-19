<?php

	include "../fungsi/koneksi.php";
	include "../fungsi/fungsi.php";

	$id_pengajuan_sementara = isset($_GET['id_pengajuan_sementara'])? $_GET['id_pengajuan_sementara']:'';
	$id_pengajuan = isset($_GET['id_pengajuan'])? $_GET['id_pengajuan']:'';

    echo $id_pengajuan_sementara.'::';
    echo $id_pengajuan.'::';

	if(isset($_GET['id'])) {
		$id = $_GET['id'];
		$tanggal = date('Y-m-d');

		$query1 = mysqli_query($koneksi, "UPDATE pengajuan SET status=1 WHERE id_pengajuan='$id' ");

		$query2 = mysqli_query($koneksi, "SELECT * FROM pengajuan WHERE id_pengajuan='$id'");

		$row = mysqli_fetch_assoc($query2);

		$query3 = mysqli_query($koneksi, "INSERT INTO pemasukan (unit, kode_brg, jumlah, tgl_masuk)
											VALUES ('$row[unit]', '$row[kode_brg]', '$row[jumlah]', '$tanggal' ) ");

		if($query3) {
			header("location:index.php?p=datapengajuan");
		} else {
			echo "ada yang salah" . mysqli_error($koneksi);
		}
	}


?>