<?php  
session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

if(isset($_POST['simpanpengajuan'])) {




    $unit = $_POST['unit'];
    //echo $unit; die;
    $status_pengajuan = "Permintaan Pengajuan Baru";
    $user_id = $_SESSION['user_id'];
	$kode_brg = $_POST['kode_brg'];
	$id_jenis = $_POST['id_jenis'];
	$jumlah = $_POST['jumlah'];	
	$satuan = $_POST['satuan'];		
	$hargabarang = preg_replace('/[Rp.]/', '', $_POST['hargabarang']);
	$total = preg_replace('/[Rp.]/', '', $_POST['total']);
    $total =  $_POST['total'];

    //echo $total; die;
	$tgl_pengajuan = date('Y-m-d');



//script validasi data

    //belum diberikan metode pengecekan jumlah barang yang diajukan
	$cek = mysqli_query($koneksi,"SELECT * FROM pengajuan_sementara WHERE kode_brg='$kode_brg' and 
tgl_pengajuan='$tgl_pengajuan' and user_id='$_SESSION[user_id]'");

	if (mysqli_num_rows($cek) > 0){
        $dt = mysqli_fetch_assoc($cek);
        $id_pengajuan_sementara = $dt['id_pengajuan_sementara'];
//        echo $id_pengajuan_sementara;
        /*cara update multi set data */
        $query = mysqli_query($koneksi,"update pengajuan_sementara set jumlah=jumlah+$_POST[jumlah],total=total+$total 
where id_pengajuan_sementara='$id_pengajuan_sementara'");

        		echo "<script>window.alert('Berhasil Menambah Jumlah Barang')
		window.location='index.php?p=formpengajuan_table'</script>";
	}else {
//		$query_bk = "INSERT into pengajuan_sementara (unit, kode_brg, id_jenis,  jumlah, satuan, hargabarang, total ,  tgl_pengajuan)
//VALUES  ('$unit', '$kode_brg', '$id_jenis', '$jumlah', '$satuan', '$hargabarang','$total', '$tgl_pengajuan')";

//		$query_bk_2 = "INSERT into pengajuan_sementara (unit,user_id, kode_brg, id_jenis,  jumlah, satuan, hargabarang, total ,  tgl_pengajuan) VALUES
//		('$unit','$_SESSION[user_id]', '$kode_brg', '$id_jenis', '$jumlah', '$satuan', '$hargabarang','$total', '$tgl_pengajuan')";

		$query = "INSERT into pengajuan_sementara (unit,user_id, kode_brg, id_jenis,  jumlah, satuan, hargabarang, total 
,tgl_pengajuan,status_pengajuan) VALUES
		('$unit','$_SESSION[user_id]', '$kode_brg', '$id_jenis', '$jumlah', 
		'$satuan', '$hargabarang','$total', '$tgl_pengajuan','Permintaan Pengajuan Baru')";
		$hasil = mysqli_query($koneksi, $query);
		if ($hasil) {
//			header("location:index.php?p=formpengajuan");
			header("location:index.php?p=formpengajuan_table&pas=formpengajuan");
		} else {
			die("ada kesalahan : " . mysqli_error($koneksi));
		}
	}
} 
?>