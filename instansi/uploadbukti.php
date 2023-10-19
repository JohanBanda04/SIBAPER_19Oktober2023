<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";
$id_sementara = $_POST['id_sementara'];
    if(isset($_POST['simpan']) && isset($_FILES['gambar'])){
        $id_sementara = $_POST['id_sementara'];
//        echo $id_sementara;
        $name= $_FILES['gambar']['name'];
        $file=$_FILES['gambar']['tmp_name'];
        $size = $_FILES['gambar']['size'];
        if($size <= 1387057 && $size>0){
            $path = "assets/file/$name";
            move_uploaded_file($file, "../$path");

            $query_get_data_detail_tb_sementara = mysqli_query($koneksi, "select * from sementara where id_sementara='$id_sementara'");
            while ($dts = mysqli_fetch_array($query_get_data_detail_tb_sementara)) {
                $unit = $dts['unit'];
                $user_id = $dts['user_id'];
                $tgl_permintaan = $dts['tgl_permintaan'];
            }

            $query_upload_bukti_foto_tb_sementara = mysqli_query($koneksi, "UPDATE sementara SET path_foto='$path',
status_acc='Selesai' WHERE id_sementara='$id_sementara'");
            echo "sukses upload...!";

            $query_update_status_tb_permintaan = mysqli_query($koneksi, "UPDATE permintaan SET status='1'
WHERE id_sementara='$id_sementara'");

            if ($query_upload_bukti_foto_tb_sementara && $query_update_status_tb_permintaan) {
                ///index.php?p=detil_history_permintaan_barang&unit=Undar&user_id=23&tgl_permintaan=2022-10-19
                echo "<script>window.alert('Berhasil Mengupload Foto dan Simpan Data')
		window.location='index.php?p=detil_history_permintaan_barang&unit=$unit&user_id=$user_id&tgl_permintaan=$tgl_permintaan'</script>";
            } else {
                echo "gagal euy cuy" . mysqli_error($koneksi);
            }
        } else {
            //http://localhost/kelola_ntb/instansi/index.php?p=terima_barang_dari_bendahara&id_sementara=276
            echo "<script>window.location='index.php?p=terima_barang_dari_bendahara&id_sementara='$id_sementara'</script>";
        }



    }


?>