<?php
//proses
session_start();
include "../fungsi/koneksi.php";
if (isset($_POST['simpan'])) {

    //pengamanan dengan mysqli_real_escape_string
//    $unit = $_POST['unit'];
    $unit = $_POST['unit'];
    $instansi = $_POST['instansi'];
    $kode_brg = $_POST['kode_brg'];
    $jumlah = $_POST['jumlah'];
    $tgl_pemesanan = date('Y-m-d');
    $id_jenis = $_POST['id_jenis'];
    $stok = $_POST['stok'];
    $sekarang = date("Y-m-d");


//    echo $unit."::";
//    echo $instansi."::";
//    echo $kode_brg."::";
//    echo $jumlah."::";
//    echo $tgl_pemesanan."::";
//    echo $id_jenis."::";
//    echo $stok."::";
//    echo $sekarang."::";


    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
//    echo $user_id.":".$username;

    $query_cek_tabel_sementara = mysqli_query($koneksi,"select * from sementara where 
unit='$_SESSION[username]' and user_id='$_SESSION[user_id]' and tgl_permintaan='$sekarang' and status_acc='Permintaan Baru'");


    if(mysqli_num_rows($query_cek_tabel_sementara)){
        //PASTIKAN disini
//        echo "ada record data";
        if((mysqli_num_rows($query_cek_tabel_sementara))>=4){
            //input dgn kode_brg baru tidak diperbolehkan tapi cek dulu klo mau nambah jumlah dgn kode barang
            // sebelumnya, masih diperbolehkan

            //cek dlu kesamaan kode_brg yg sebelumny sudah ada di db, dgn kode barang yg diinput user
            $eksis_old = mysqli_query($koneksi,"select * from sementara where unit='$_SESSION[username]' 
and kode_brg='$kode_brg' and tgl_permintaan='$sekarang'");

            $eksis = mysqli_query($koneksi,"select * from sementara where unit='$_SESSION[username]' 
and user_id='$_SESSION[user_id]' and kode_brg='$kode_brg' and status_acc='Permintaan Baru' and tgl_permintaan='$sekarang'");

            if(mysqli_num_rows($eksis) > 0){
//                echo "ada kode barang yg sama , sudah pernah dimasukkan tapi mau ditambah kuantitas ny utk per 1 kode brg";
                $dt = mysqli_fetch_array($eksis);
                $jml_brg_sebelumnya = $dt['jumlah'];
                $id_sementara = $dt['id_sementara'];
                $jumlah_total = $jml_brg_sebelumnya+$jumlah;
                $query_update_jumlah = mysqli_query($koneksi,"update sementara set 
 jumlah='$jumlah_total' where unit='$_SESSION[username]' and id_sementara='$id_sementara' 
and tgl_permintaan='$sekarang'");
                echo "<script>window.alert('Berhasil menambah jumlah ')
		window.location='index.php?p=formpesan'</script>";
            } else {
                echo "<script>window.alert('Jumlah Permintaan Sudah Maksimum Pada Sesi ini, Ajukan Pemberitahuan Kasub terlebih dahulu')
		window.location='index.php?p=formpesan'</script>";
            }
        } else if((mysqli_num_rows($query_cek_tabel_sementara))<4) {
            //input dgn kode_brg baru diperbolehkan
//            echo "jumlah barang masih kurang dari 4";

            $eksis_bk = mysqli_query($koneksi,"select * from sementara where unit='$_SESSION[username]' 
and kode_brg='$kode_brg' and tgl_permintaan='$sekarang'");

            $eksis = mysqli_query($koneksi,"select * from sementara where unit='$_SESSION[username]' 
and user_id='$_SESSION[user_id]' and kode_brg='$kode_brg' and status_acc='Permintaan Baru' and tgl_permintaan='$sekarang'");
            if(mysqli_num_rows($eksis) > 0 ){
                $dt= mysqli_fetch_array($eksis);
                $jml_brg_sebelumnya = $dt['jumlah'];
                $id_sementara = $dt['id_sementara'];
                $jml_total = $jml_brg_sebelumnya+$jumlah;
                $query_update_jumlah = mysqli_query($koneksi,"update sementara 
set jumlah='$jml_total' where unit='$_SESSION[username]' and id_sementara='$id_sementara' and 
tgl_permintaan='$sekarang'");
                echo "<script>window.alert('Berhasil menambah jumlah ')
		window.location='index.php?p=formpesan'</script>";
            } else {
                $query_insert = mysqli_query($koneksi,"INSERT INTO sementara ( unit, user_id, instansi, 
kode_brg, id_jenis, jumlah, tgl_permintaan,status,
pemberitahuan_kasub,acc_kasub, id_subbidang,status_acc)
VALUES ('$_SESSION[username]', '$_SESSION[user_id]', '$_SESSION[level]', '$kode_brg', '$id_jenis','$jumlah', 
'$sekarang','0','0','0','$_SESSION[subbidang_id]','Permintaan Baru')");
                if($query_insert){
                    echo "<script>window.alert('Sukses Input Data')
		window.location='index.php?p=formpesan'</script>";
                } else {
                    die("ada kesalahan : " . mysqli_error($koneksi));
                }
            }
        }
    } else {
//        echo "tdk ada record data";
        if((mysqli_num_rows($query_cek_tabel_sementara))<4){
            $query_insert = mysqli_query($koneksi,"INSERT INTO sementara ( unit, user_id, instansi, 
kode_brg, id_jenis, jumlah, tgl_permintaan,status,
pemberitahuan_kasub,acc_kasub, id_subbidang,status_acc)
VALUES ('$_SESSION[username]', '$_SESSION[user_id]', '$_SESSION[level]', '$kode_brg', '$id_jenis','$jumlah', 
'$sekarang','0','0','0','$_SESSION[subbidang_id]','Permintaan Baru')");
            if($query_insert){
                echo "<script>window.alert('Sukses Input Data')
		window.location='index.php?p=formpesan'</script>";
            } else {
                die("ada kesalahan : " . mysqli_error($koneksi));
            }
        }
    }

//    $query_cek_jml_req_per_hari = mysqli_query($koneksi,"Select * from sementara where user_id=$user_id
//and tgl_permintaan='$sekarang'");
//    if (mysqli_num_rows($query_cek_jml_req_per_hari)>=3){
//        echo "<script>window.alert('Jumlah Permintaan Sudah Maksimum Pada Hari ini')
//		window.location='index.php?p=formpesan'</script>";
//    } else {
//        $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM sementara WHERE
//kode_brg='$kode_brg'
// AND user_id=$_SESSION[user_id] and tgl_permintaan=$sekarang"));
//// filter and tgl_permintaan='$sekarang' dihilangkan pada query diatas
//
//
//        $getJumlah = 0;
//        $getJumlahSementara = mysqli_query($koneksi, "select * from sementara WHERE kode_brg='$kode_brg' and tgl_permintaan='$sekarang'");
//        if (mysqli_num_rows($getJumlahSementara)) {
//            $getJml = 0;
//            while ($dt = mysqli_fetch_assoc($getJumlahSementara)) {
//                $getJml += $dt['jumlah'];
//            }
//            $getJumlah += $getJml;
//        }
//
//
//        if ($cek > 0) {
//            $jmlTotal = intval($jumlah) + intval($getJumlah);
//            $user_id = $_SESSION['user_id'];
//            // disini tambah ke tabel sementara utk jumlah request
//            $query1 = mysqli_query($koneksi, "UPDATE sementara SET jumlah=jumlah+$jumlah,tgl_permintaan='$sekarang' WHERE kode_brg=$kode_brg AND user_id='$user_id'");
//            echo "<script>window.alert('Ingin Menambah Jumlah Permintaan?')
//		window.location='index.php?p=formpesan'</script>";
//        } else {
//
////        $q_jml_request = mysqli_query($koneksi, "SELECT * from sementara
////where unit='$_SESSION[username]' and status=0 and user_id=$_SESSION[user_id] and status_acc != 'Selesai'");
////
////        echo mysqli_num_rows($q_jml_request);
//
//            $subbidang_id = $_SESSION['subbidang_id'];
//            $user_id = $_SESSION['user_id'];
//            $query = "INSERT into sementara (unit, instansi, kode_brg, id_jenis,  jumlah, tgl_permintaan, id_subbidang,user_id, status_acc) VALUES
//		('$unit','$instansi', '$kode_brg', '$id_jenis', '$jumlah', '$tgl_pemesanan','$subbidang_id','$user_id','Permintaan Baru')";
//            $hasil = mysqli_query($koneksi, $query);
//            if ($hasil) {
//                header("location:index.php?p=formpesan");
//            } else {
//                die("ada kesalahan : " . mysqli_error($koneksi));
//            }
//
//
//        }
//    }


}
?>