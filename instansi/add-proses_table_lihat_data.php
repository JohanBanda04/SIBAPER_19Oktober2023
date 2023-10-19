<?php
session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

//echo "tes";

if(isset($_POST['tampilkan'])){
    $tanggala = $_POST['tanggala'];
    $tanggalb = $_POST['tanggalb'];
    $jenis_brg = $_POST['jenis_brg'];
    $nama_brg = $_POST['nama_brg'];

    echo $tanggala."::";
    echo $tanggalb."::";
    echo $jenis_brg."::";
    echo $nama_brg."::";



    //metode cetak variabel pada alert
    echo "<script>window.alert('Filtered $tanggala, $tanggalb, $jenis_brg, $nama_brg')
		window.location='index.php?p=history_permintaan_barang_table&pa=history_pengguna'</script>";
    ///index.php?p=history_permintaan_barang_table&pa=history_pengguna
//    if($query_update_sementara && $query_insert_permintaan){
//        echo "<script>window.alert('Permintaan Barang Berhasil Diajukan Ke Bendahara')
//		window.location='index.php?p=history_permintaan_barang_table&pa=history_pengguna'</script>";
//    } else {
//        echo "gagal euy cuy" . mysqli_error($koneksi);
//    }
}

?>