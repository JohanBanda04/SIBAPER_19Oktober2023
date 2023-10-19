<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";
$id_sementara = $_POST['id_sementara'];

$unit = $_POST['unit'];
$tgl_permintaan = $_POST['tgl_permintaan'];
$user_id = $_POST['user_id'];
$bendahara_id = $_POST['bendahara_id'];

//echo $id_sementara."::";
//echo $unit."::";
//echo $tgl_permintaan."::";
//echo $user_id."::";
//echo $bendahara_id."::";

//index.php?p=detilpermintaan&unit=Bela&tgl=2022-10-19&user_id_pemohon=26&bendahara_id=21

if(isset($_POST['simpanbuktipenyerahan']) && isset($_FILES['gambar'])){
    $id_sementara = $_POST['id_sementara'];
    $name = $_FILES['gambar']['name'];
    $file = $_FILES['gambar']['tmp_name'];
    $size = $_FILES['gambar']['size'];

    if($size>0 && $size <= 1387057 ){
        $path = "assets/file/$name";
        move_uploaded_file($file,"../$path");

        $query_get_data_detail_tb_sementara = mysqli_query($koneksi,"select * from sementara where id_sementara='$id_sementara'");
        while($dt = mysqli_fetch_array($query_get_data_detail_tb_sementara)){

            $unit = $dt['unit'];
            $user_id = $dt['user_id'];
            $tgl_permintaan = $dt['tgl_permintaan'];
            $user_id_pemohon = $dt['user_id'];
            $bendahara_id = $dt['bendahara_id'];

            $query_upload_path_foto_bukti_tb_sementara = mysqli_query($koneksi,"update sementara set path_foto='$path',
status_acc='Selesai' where id_sementara='$id_sementara'");

            $query_update_status_tb_permintaans = mysqli_query($koneksi,"update permintaan set status='1'
where id_sementara='$id_sementara'");

//id
//unit
//user_id
//kode_brg
//jumlah
//tgl_keluar
//id_sementara

//            $query_insert_pengeluaran = mysqli_query($koneksi,"INSERT into pengeluaran
//(unit, user_id, kode_brg, kode_brg, jumlah, jumlah, tgl_keluar, id_sementara)
//VALUES	('$_SESSION[username]', '$_SESSION[user_id]', '$_SESSION[level]',
//'$kode_brg', '$id_jenis', '$jumlah_brg','$tgl_permintaan', '$status','$id_sementara')");

            if($query_upload_path_foto_bukti_tb_sementara && $query_update_status_tb_permintaans){
                //index.php?p=detilpermintaan&unit=Bela&tgl=2022-10-19&user_id_pemohon=26&bendahara_id=21
                //index.php?p=detilpermintaan&unit=Bela&tgl=2022-10-19&user_id_pemohon=26&bendahara_id=21
                echo "<script>window.alert('Berhasil Upload Foto dan Simpan Data')
		window.location='index.php?p=detilpermintaan&unit=$dt[unit]&tgl=$dt[tgl_permintaan]&user_id_pemohon=$dt[user_id]&bendahara_id=$dt[bendahara_id]'</script>";
            } else {
                echo "gagal euy cuy" . mysqli_error($koneksi);
            }

        }


    } else {
//        echo "<script>window.location='index.php?p=terima_barang_dari_bendahara&id_sementara='$id_sementara'</script>";
    }
}



?>