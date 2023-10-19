<?php
session_start();
include "../fungsi/fungsi.php";
include "../fungsi/koneksi.php";

if(isset($_POST['ajukan_pengajuansementara'])){
    $id_pengajuan_sementara = $_POST['id_pengajuan_sementara'];
    $unit = $_POST['unit'];
    $kode_brg = $_POST['kode_brg'];
    $id_jenis = $_POST['id_jenis'];
    $jumlah = $_POST['jumlah'];
    $satuan = $_POST['satuan'];
    $hargabarang = $_POST['hargabarang'];
    $total = $_POST['total'];
    $tgl_pengajuan = $_POST['tgl_pengajuan'];


    $query_cek_tb_pengajuan = mysqli_query($koneksi,"select * from pengajuan where 
id_pengajuan_sementara='$id_pengajuan_sementara'");

    if(mysqli_num_rows($query_cek_tb_pengajuan)<=0){
        //echo "belum ada data nya di tb pengajuan";
        $query_update_status_tb_pengajuan_sementara = mysqli_query($koneksi,"update pengajuan_sementara set
status_pengajuan='setujui pengajuan',status='0' where id_pengajuan_sementara='$id_pengajuan_sementara' and user_id='$_SESSION[user_id]'
and unit='$unit' and status_pengajuan='Permintaan Pengajuan Baru'");

        $query_update_insert_tb_perngajuan = mysqli_query($koneksi,"insert into pengajuan
(unit,user_id,kode_brg,id_jenis,jumlah,satuan,hargabarang,total,tgl_pengajuan,status,id_pengajuan_sementara)
values
('$unit','$_SESSION[user_id]','$kode_brg','$id_jenis','$jumlah','$satuan','$hargabarang','$total','$tgl_pengajuan','0','$id_pengajuan_sementara')");
        if($query_update_status_tb_pengajuan_sementara && $query_update_insert_tb_perngajuan){
            header("Location:index.php?p=formpengajuan_table");
        } else {
            echo "gagal euy" . mysqli_error($koneksi);
        }

    } else if(mysqli_num_rows($query_cek_tb_pengajuan)>0) {
//                echo "nama bendahara tidak sama";
        /*harusnya disini tb_pengajuan diupdate jumlah nya*/
        //index.php?p=formpengajuan&pas=formpengajuan
        echo "<script>window.alert('Maaf, Data Sudah Ada Pada Tabel Pengajuan')
		window.location='index.php?p=formpengajuan_table&pas=formpengajuan'</script>";
    }
}


//if(mysqli_query($koneksi, $query)){
//    mysqli_query($koneksi, $query2);
//    echo '<script language="javascript">alert("Form Pengajuan Berhasil Di Buat  !!!");
//document.location="index.php?p=datapengajuan";
//</script>';
//} else {
//    echo "gagal euy" . mysqli_error($koneksi);
//}
//
//if(isset($_GET['id'])) {
//    $id = $_GET['id'];
//    $query = mysqli_query($koneksi, "DELETE FROM pengajuan_sementara WHERE id_pengajuan_sementara='$id' ");
//
//    if($query) {
//        header("Location:index.php?p=formpengajuan");
//    }
//}


?>