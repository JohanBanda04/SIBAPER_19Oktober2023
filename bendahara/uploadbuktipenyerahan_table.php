<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";
$id_sementara = $_POST['id_sementara'];
//echo $_POST["id_sementara"]; die;


$unit = $_POST['unit'];
$tgl_permintaan = $_POST['tgl_permintaan'];
$user_id = $_POST['user_id'];
$bendahara_id = $_POST['bendahara_id'];

//echo $id_sementara."::";
//echo $unit."::";
//echo $tgl_permintaan."::";
//echo $user_id."::";
//echo $bendahara_id."::";

//echo '<pre>';
//print_r($_POST); die;

//index.php?p=detilpermintaan&unit=Bela&tgl=2022-10-19&user_id_pemohon=26&bendahara_id=21
//echo $id_sementara; die;
if(isset($_POST['simpanbuktipenyerahan']) && isset($_FILES['gambar'])){

    $query_cek_data =  mysqli_query($koneksi,"select * from sementara inner join 
stokbarang on sementara.kode_brg=stokbarang.kode_brg where sementara.id_sementara='$id_sementara'");

    while($data = mysqli_fetch_array($query_cek_data)){

        $path_foto_old = $data['path_foto'];

        //echo "<pre>"; print_r($path_foto_old); die;

        explode('/',$path_foto_old)[2];
        //echo $path_foto_old; die;
    }


    $id_sementara = $_POST['id_sementara'];
    //echo $path_foto_old; die;

    $name = $_FILES['gambar']['name'];
    //echo $name; die;
    $file = $_FILES['gambar']['tmp_name'];
    $size = $_FILES['gambar']['size'];

    if($path_foto_old!=""){
        if($name == explode('/',$path_foto_old)[2]){
            $filename_to_upload = explode('/',$path_foto_old)[2];

//            try{
//                unlink($path_foto_old);
//            } catch (Exception $e){
//                echo json_encode($e);
//            }

            if($size>0 && $size <= 1387057 ){
                //$path = "assets/file/$name";
                $path = "assets/file/$filename_to_upload";
                $test_path = "../$path";
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


                    if($query_upload_path_foto_bukti_tb_sementara && $query_update_status_tb_permintaans){
                        //index.php?p=detilpermintaan&unit=Bela&tgl=2022-10-19&user_id_pemohon=26&bendahara_id=21
                        //index.php?p=detilpermintaan&unit=Bela&tgl=2022-10-19&user_id_pemohon=26&bendahara_id=21
                        echo "<script>window.alert('Berhasil Upload Foto dan Simpan Data')
		window.location='index.php?p=detilpermintaan_table&unit=$dt[unit]&tgl=$dt[tgl_permintaan]&user_id_pemohon=$dt[user_id]&bendahara_id=$dt[bendahara_id]'</script>";
                    } else {
                        echo "gagal euy cuy" . mysqli_error($koneksi);
                    }

                }


            } else {
                echo "<script>window.alert('Upload Gagal! Size Foto Lebih Dari 1 Mb')
		window.location='index.php?p=sudah_serahkan_barang_ke_pengguna_table&id_sementara=$id_sementara'</script>";
            }
        } else if ($name != explode('/',$path_foto_old)[2]){
//            kuker
            //echo "kuker"; die;
            $filename_to_upload = $name;
            //echo $filename_to_upload."<br>";
            //echo $path_foto_old = "https://localhost/kelola_ntb/".$path_foto_old; die;

//            $file_name = explode('/',$path_foto_old)[2];
//            $file_delete = dirname(__FILE__, 2) . '\\u\\' . $file_name;
            //unlink($path_foto_old);
//            try{
//                unlink($path_foto_old);
//            } catch (Exception $e){
//                echo json_encode($e);
//            }
            if($size>0 && $size <= 1387057 ){
                //$path = "assets/file/$name";
                $path = "assets/file/$filename_to_upload";
                $test_path = "../$path";
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


                    if($query_upload_path_foto_bukti_tb_sementara && $query_update_status_tb_permintaans){
                        //index.php?p=detilpermintaan&unit=Bela&tgl=2022-10-19&user_id_pemohon=26&bendahara_id=21
                        //index.php?p=detilpermintaan&unit=Bela&tgl=2022-10-19&user_id_pemohon=26&bendahara_id=21
                        echo "<script>window.alert('Berhasil Upload Foto dan Simpan Data')
		window.location='index.php?p=detilpermintaan_table&unit=$dt[unit]&tgl=$dt[tgl_permintaan]&user_id_pemohon=$dt[user_id]&bendahara_id=$dt[bendahara_id]'</script>";
                    } else {
                        echo "gagal euy cuy" . mysqli_error($koneksi);
                    }

                }


            } else {
                echo "<script>window.alert('Upload Gagal! Size Foto Lebih Dari 1 Mb')
		window.location='index.php?p=sudah_serahkan_barang_ke_pengguna_table&id_sementara=$id_sementara'</script>";
            }
        }
    } else if ($path_foto_old==""){
        $name = $_FILES['gambar']['name'];
        $file = $_FILES['gambar']['tmp_name'];
        //echo "file : ".$file; die;
        //echo "nama photo : ".$name ; die;
        $filename_to_upload = $name;
        if($size>0 && $size <= 1387057 ){

            //$path = "assets/file/$name";
            $path = "assets/file/$filename_to_upload";
            //echo $path; die;
            $test_path = "../$path";
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


                if($query_upload_path_foto_bukti_tb_sementara && $query_update_status_tb_permintaans){
                    //index.php?p=detilpermintaan&unit=Bela&tgl=2022-10-19&user_id_pemohon=26&bendahara_id=21
                    //index.php?p=detilpermintaan&unit=Bela&tgl=2022-10-19&user_id_pemohon=26&bendahara_id=21
                    echo "<script>window.alert('Berhasil Upload Foto dan Simpan Data')
		window.location='index.php?p=detilpermintaan_table&unit=$dt[unit]&tgl=$dt[tgl_permintaan]&user_id_pemohon=$dt[user_id]&bendahara_id=$dt[bendahara_id]'</script>";
                } else {
                    echo "gagal euy cuy" . mysqli_error($koneksi);
                }

            }


        } else {
            echo "<script>window.alert('Upload Gagal! Size Foto Lebih Dari 1 Mb')
		window.location='index.php?p=sudah_serahkan_barang_ke_pengguna_table&id_sementara=$id_sementara'</script>";
        }
    }

    /*hapus aja dari sini*/
//    if($name==""){
//        $filename_to_upload = explode('/',$path_foto_old)[2];
//
//        echo "tdk ada upload foto, dan tdk ada yg harus di unlink <br>".$filename_to_upload; die;
//
//    } else if( $name != "" ){
//        if($path_foto_old==""){
//            $filename_to_upload = $name;
//
//
//        } else if ($path_foto_old!=""){
//            if($name==explode('/',$path_foto_old)[2]){
//                $filename_to_upload = explode('/',$path_foto_old)[2];
//
//            } else if ($name != explode('/',$path_foto_old)[2]) {
//                $filename_to_upload = $name;
//
//                try{
//                    unlink($path_foto_old);
//                } catch (Exception $e){
//                    echo json_encode($e);
//                }
//            }
//        }
//
//    }
    /*hapus aja sampai sini*/

    /*hapus aja dari sini 2*/
//    if($path_foto_old!=""){
//        if($name == explode('/',$path_foto_old)[2]){
//            $filename_to_upload = explode('/',$path_foto_old)[2];
//            try{
//                unlink($path_foto_old);
//            } catch (Exception $e){
//                echo json_encode($e);
//            }
//            if($size>0 && $size <= 1387057 ){
//                //$path = "assets/file/$name";
//                $path = "assets/file/$filename_to_upload";
//                $test_path = "../$path";
//                move_uploaded_file($file,"../$path");
//                $query_get_data_detail_tb_sementara = mysqli_query($koneksi,"select * from sementara where id_sementara='$id_sementara'");
//                while($dt = mysqli_fetch_array($query_get_data_detail_tb_sementara)){
//
//                    $unit = $dt['unit'];
//                    $user_id = $dt['user_id'];
//                    $tgl_permintaan = $dt['tgl_permintaan'];
//                    $user_id_pemohon = $dt['user_id'];
//                    $bendahara_id = $dt['bendahara_id'];
//
//                    $query_upload_path_foto_bukti_tb_sementara = mysqli_query($koneksi,"update sementara set path_foto='$path',
//status_acc='Selesai' where id_sementara='$id_sementara'");
//
//                    $query_update_status_tb_permintaans = mysqli_query($koneksi,"update permintaan set status='1'
//where id_sementara='$id_sementara'");
//
//
//                    if($query_upload_path_foto_bukti_tb_sementara && $query_update_status_tb_permintaans){
//                        //index.php?p=detilpermintaan&unit=Bela&tgl=2022-10-19&user_id_pemohon=26&bendahara_id=21
//                        //index.php?p=detilpermintaan&unit=Bela&tgl=2022-10-19&user_id_pemohon=26&bendahara_id=21
//                        echo "<script>window.alert('Berhasil Upload Foto dan Simpan Data')
//		window.location='index.php?p=detilpermintaan_table&unit=$dt[unit]&tgl=$dt[tgl_permintaan]&user_id_pemohon=$dt[user_id]&bendahara_id=$dt[bendahara_id]'</script>";
//                    } else {
//                        echo "gagal euy cuy" . mysqli_error($koneksi);
//                    }
//
//                }
//
//
//            } else {
////        echo "<script>window.location='index.php?p=terima_barang_dari_bendahara&id_sementara='$id_sementara'</script>";
//            }
//        } else if($name != explode('/',$path_foto_old)[2])  {
//            //echo "data foto tidak sama"; die;
//            try{
//                unlink($path_foto_old);
//            } catch (Exception $e){
//                echo json_encode($e);
//            }
//            $filename_to_upload = $name;
//            if($size>0 && $size <= 1387057 ){
//                //$path = "assets/file/$name";
//                $path = "assets/file/$filename_to_upload";
//                $test_path = "../$path";
////        var_dump($test_path) ;
//                move_uploaded_file($file,"../$path");
////        var_dump(move_uploaded_file($file,"../$path"));
//                $query_get_data_detail_tb_sementara = mysqli_query($koneksi,"select * from sementara where id_sementara='$id_sementara'");
//                while($dt = mysqli_fetch_array($query_get_data_detail_tb_sementara)){
//
//                    $unit = $dt['unit'];
//                    $user_id = $dt['user_id'];
//                    $tgl_permintaan = $dt['tgl_permintaan'];
//                    $user_id_pemohon = $dt['user_id'];
//                    $bendahara_id = $dt['bendahara_id'];
//
//                    $query_upload_path_foto_bukti_tb_sementara = mysqli_query($koneksi,"update sementara set path_foto='$path',
//status_acc='Selesai' where id_sementara='$id_sementara'");
//
//                    $query_update_status_tb_permintaans = mysqli_query($koneksi,"update permintaan set status='1'
//where id_sementara='$id_sementara'");
//
//
//                    if($query_upload_path_foto_bukti_tb_sementara && $query_update_status_tb_permintaans){
//                        //index.php?p=detilpermintaan&unit=Bela&tgl=2022-10-19&user_id_pemohon=26&bendahara_id=21
//                        //index.php?p=detilpermintaan&unit=Bela&tgl=2022-10-19&user_id_pemohon=26&bendahara_id=21
//                        echo "<script>window.alert('Berhasil Upload Foto dan Simpan Data')
//		window.location='index.php?p=detilpermintaan_table&unit=$dt[unit]&tgl=$dt[tgl_permintaan]&user_id_pemohon=$dt[user_id]&bendahara_id=$dt[bendahara_id]'</script>";
//                    } else {
//                        echo "gagal euy cuy" . mysqli_error($koneksi);
//                    }
//
//                }
//
//
//            } else {
////        echo "<script>window.location='index.php?p=terima_barang_dari_bendahara&id_sementara='$id_sementara'</script>";
//            }
//        }
//    } else if ($path_foto_old==""){
//        //echo "wkwkwk";
//        $filename_to_upload = $name;
//        if($size>0 && $size <= 1387057 ){
//            //$path = "assets/file/$name";
//            $path = "assets/file/$filename_to_upload";
//            $test_path = "../$path";
////        var_dump($test_path) ;
//            move_uploaded_file($file,"../$path");
////        var_dump(move_uploaded_file($file,"../$path"));
//            $query_get_data_detail_tb_sementara = mysqli_query($koneksi,"select * from sementara where id_sementara='$id_sementara'");
//            while($dt = mysqli_fetch_array($query_get_data_detail_tb_sementara)){
//
//                $unit = $dt['unit'];
//                $user_id = $dt['user_id'];
//                $tgl_permintaan = $dt['tgl_permintaan'];
//                $user_id_pemohon = $dt['user_id'];
//                $bendahara_id = $dt['bendahara_id'];
//
//                $query_upload_path_foto_bukti_tb_sementara = mysqli_query($koneksi,"update sementara set path_foto='$path',
//status_acc='Selesai' where id_sementara='$id_sementara'");
//
//                $query_update_status_tb_permintaans = mysqli_query($koneksi,"update permintaan set status='1'
//where id_sementara='$id_sementara'");
//
//
//                if($query_upload_path_foto_bukti_tb_sementara && $query_update_status_tb_permintaans){
//                    //index.php?p=detilpermintaan&unit=Bela&tgl=2022-10-19&user_id_pemohon=26&bendahara_id=21
//                    echo "<script>window.alert('Berhasil Upload Foto dan Simpan Data')
//		window.location='index.php?p=detilpermintaan_table&unit=$dt[unit]&tgl=$dt[tgl_permintaan]&user_id_pemohon=$dt[user_id]&bendahara_id=$dt[bendahara_id]'</script>";
//                } else {
//                    echo "gagal euy cuy" . mysqli_error($koneksi);
//                }
//
//            }
//
//
//        } else {
////        echo "<script>window.location='index.php?p=terima_barang_dari_bendahara&id_sementara='$id_sementara'</script>";
//            echo "<script>window.alert('Upload Gagal! Size Foto Lebih Dari 1 Mb')
//		window.location='index.php?p=sudah_serahkan_barang_ke_pengguna_table&id_sementara=$id_sementara'</script>";
//        }
//
//    }

/*hapus aja sampai sini 2*/

}



?>




