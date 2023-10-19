<?php
session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

if(isset($_POST['update_jumlah_brg'])){

    $id_sementara = $_POST['id_sementara'];
    $unit = $_POST['unit'];
    $kode_brg = $_POST['kode_brg'];
    $jumlah = $_POST['jumlah'];
    $tgl_permintaan = $_POST['tgl_permintaan'];
    $user_id = $_POST['user_id'];
    $catatan_bendahara = $_POST['catatan_bendahara'];
    $bendahara_id = $_SESSION['user_id']??'';
    $bendahara = ucfirst($_SESSION['username'])??'';

//    echo $id_sementara."::";
//    echo $unit."::";
//    echo $kode_brg."::";
//    echo $jumlah."::";
//    echo $tgl_permintaan."::";
//    echo $user_id."::";
//    echo $catatan_bendahara."::";
//    echo $bendahara_id."::";
//    echo $bendahara."::";

//update sementara set jumlah='3' where id_sementara='245'
    //    update permintaan set jumlah='3' where id_sementara='245'
//---------------------------------------------------------
    $cek_bendahara = mysqli_query($koneksi,"select * from sementara where id_sementara='$id_sementara'");

    if($cek_bendahara){
        $dts = mysqli_fetch_assoc($cek_bendahara);
        if($dts['bendahara_id']==''||$dts['bendahara_id']==null){
//            echo "belum ada bendaharanya";
//            $query_update_sementara_bk = mysqli_query($koneksi,"update sementara set jumlah='$jumlah' where id_sementara='$id_sementara'");
            $query_update_sementara = mysqli_query($koneksi,"update sementara set jumlah='$jumlah',note_bendahara='$catatan_bendahara',
bendahara_id='$bendahara_id',bendahara='$bendahara' where id_sementara='$id_sementara'");
            $query_update_permintaan = mysqli_query($koneksi,"update permintaan set jumlah='$jumlah' where id_sementara='$id_sementara'");

            if($query_update_sementara && $query_update_permintaan){
                //index.php?p=detilpermintaan&unit=Undar&tgl=2022-10-05&user_id_pemohon=23
//        header("location:index.php?p=detilpermintaan&unit=$unit&tgl=$tgl_permintaan&user_id_pemohon=$user_id");

                echo "<script>window.alert('Jumlah Permintaan Barang Berhasil Diubah')
		window.location='index.php?p=detilpermintaan&unit=$unit&tgl=$tgl_permintaan&user_id_pemohon=$user_id'</script>";
            } else {
                echo "gagal euy cuy" . mysqli_error($koneksi);
            }
        } else {
//            echo "sudah ada bendaharanya";
            //sudah ada bendahara nya, maka lakukan pengecekan apakah nama yg sudah ada sama dengan session username yg login

            $queries = mysqli_query($koneksi,"select * from sementara where id_sementara='$id_sementara'");
            $item = mysqli_fetch_assoc($queries);
            //sampai echo ini berhasil sudah
//            echo $item['bendahara'];

            if(ucfirst($_SESSION['username'])==$item['bendahara']){
//                echo "nama bendahara sama";
                $query_update_sementara_after_edit_dari_bendahara = mysqli_query($koneksi,"update sementara set 
jumlah='$jumlah',note_bendahara='$catatan_bendahara',
bendahara_id='$bendahara_id',bendahara='$bendahara' where id_sementara='$id_sementara'");

                $query_update_permintaan_after_edit_dari_bendahara = mysqli_query($koneksi,"update permintaan set 
jumlah='$jumlah' where id_sementara='$id_sementara'");

                if($query_update_sementara_after_edit_dari_bendahara && $query_update_permintaan_after_edit_dari_bendahara){
                    //index.php?p=detilpermintaan&unit=Undar&tgl=2022-10-05&user_id_pemohon=23
//        header("location:index.php?p=detilpermintaan&unit=$unit&tgl=$tgl_permintaan&user_id_pemohon=$user_id");

                    echo "<script>window.alert('Permintaan Barang Berhasil Diubah')
		window.location='index.php?p=detilpermintaan_table&unit=$unit&tgl=$tgl_permintaan&user_id_pemohon=$user_id'</script>";
                } else {
                    echo "gagal euy cuy" . mysqli_error($koneksi);
                }
            } else {
//                echo "nama bendahara tidak sama";
                echo "<script>window.alert('Maaf, Sudah Ada Bendahara Lain Yang Memproses Permintaan Ini')
		window.location='index.php?p=detilpermintaan_table&unit=$unit_pemohon&tgl=$tgl_permintaan&user_id_pemohon=$user_id_pemohon&bendahara_id=$bendahara_id'</script>";
            }

            //index.php?p=detilpermintaan&unit=Undar&tgl=2022-11-01&user_id_pemohon=23&bendahara_id=
//            echo "<script>window.alert('Maaf, Sudah Ada Bendahara Lain Yang Memproses Permintaan Ini')
//		window.location='index.php?p=detilpermintaan&unit=$unit_pemohon&tgl=$tgl_permintaan&user_id_pemohon=$user_id_pemohon&bendahara_id=$bendahara_id'</script>";
        }
    } else {
        echo "gagal cek_bendahara" . mysqli_error($koneksi);
    }
//------------------------------------------------------------------------
//    $query_update_sementara = mysqli_query($koneksi,"update sementara set jumlah='$jumlah' where id_sementara='$id_sementara'");
//    $query_update_permintaan = mysqli_query($koneksi,"update permintaan set jumlah='$jumlah' where id_sementara='$id_sementara'");
//
//    if($query_update_sementara && $query_update_permintaan){
//        //index.php?p=detilpermintaan&unit=Undar&tgl=2022-10-05&user_id_pemohon=23
////        header("location:index.php?p=detilpermintaan&unit=$unit&tgl=$tgl_permintaan&user_id_pemohon=$user_id");
//
//        echo "<script>window.alert('Jumlah Permintaan Barang Berhasil Diubah')
//		window.location='index.php?p=detilpermintaan&unit=$unit&tgl=$tgl_permintaan&user_id_pemohon=$user_id'</script>";
//    } else {
//        echo "gagal euy cuy" . mysqli_error($koneksi);
//    }



}

?>