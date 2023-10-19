<?php

include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";
include "../classes/class.phpmailer.php";

session_start();
$nama_unit = $_GET['unit'];
$tgl_minta = $_GET['tgl_minta'];
$subbidang_id = $_SESSION['subbidang_id'];

//echo $_SESSION['subbidang_id']; die;
$query_get_email_tujuan = mysqli_query($koneksi,"select user.id_user, user.username, user.nama_lengkap , 
user.email, user.subbidang_id, user.jabatan_detail from user where 
subbidang_id='$_SESSION[subbidang_id]' and level='kasub_pengguna'");


$data_get_email_tujuan = mysqli_fetch_assoc($query_get_email_tujuan);

$get_email_tujuan = $data_get_email_tujuan['email'];
$get_nama_lengkap_tujuan = $data_get_email_tujuan['nama_lengkap'];
$get_jabatan_detail_tujuan = $data_get_email_tujuan['jabatan_detail'];
$get_subbidang_id_tujuan = $data_get_email_tujuan['subbidang_id'];

$query_get_nama_subbidang = mysqli_query($koneksi,"SELECT * from subbidang where id_subbidang='$get_subbidang_id_tujuan'");
$data_get_nama_subbidang_tujuan = mysqli_fetch_assoc($query_get_nama_subbidang);
$get_nama_subbidang_tujuan = $data_get_nama_subbidang_tujuan['nama_subbidang'];

//echo $get_email_tujuan."<br>";
//echo $get_nama_lengkap_tujuan."<br>";
//echo $get_jabatan_detail_tujuan."<br>";
//echo $get_subbidang_id_tujuan."<br>";
//echo $get_nama_subbidang_tujuan."<br>"; die;

$get_nama_lengkap_penerima = $data_get_email_tujuan['nama_lengkap'];

/*cukys sini PENGIRIM sesuaikan!*/
//echo $_SESSION['subbidang_id']; die;
$query_get_email_pengirim = mysqli_query($koneksi,"select user.id_user, user.username, user.nama_lengkap , 
user.email, user.subbidang_id, user.jabatan_detail from user where 
subbidang_id='$_SESSION[subbidang_id]' and level='pengguna'");


$data_get_email_pengirim = mysqli_fetch_assoc($query_get_email_pengirim);

$get_email_pengirim = $data_get_email_pengirim['email'];
$get_nama_lengkap_pengirim = $data_get_email_pengirim['nama_lengkap'];
$get_jabatan_detail_pengirim = $data_get_email_pengirim['jabatan_detail'];
$get_subbidang_id_pengirim = $data_get_email_pengirim['subbidang_id'];

$query_get_nama_subbidang_pengirim = mysqli_query($koneksi,"SELECT * from subbidang where id_subbidang='$get_subbidang_id_pengirim'");
$data_get_nama_subbidang_pengirim = mysqli_fetch_assoc($query_get_nama_subbidang_pengirim);
$get_nama_subbidang_pengirim = $data_get_nama_subbidang_pengirim['nama_subbidang'];

//echo $get_email_pengirim."<br>";
//echo $get_nama_lengkap_pengirim."<br>";
//echo $get_jabatan_detail_pengirim."<br>";
//echo $get_subbidang_id_pengirim."<br>";
//echo $get_nama_subbidang_pengirim."<br>"; die;

/*cukys sampai sini PENGIRIM*/



$tgl_sekarang = date('Y-m-d');

$query_cek_kode_brg = mysqli_query($koneksi,"select * from sementara where unit='$_SESSION[username]'
and user_id='$_SESSION[user_id]' and tgl_permintaan='$tgl_sekarang'");

$array_cek_4 = array();
//echo "jumlah baris db : ".mysqli_fetch_array($query_cek_kode_brg); die;
while ($dts = mysqli_fetch_array($query_cek_kode_brg)){
    array_push($array_cek_4,$dts['jumlah']);
}

$array_cek = array();
foreach ($array_cek_4 as $val){
    if($val > 1000){
        array_push($array_cek,"tidak memenuhi syarat");
    } else if ($val <= 1000 ){
        array_push($array_cek,"memenuhi syarat");
    }
}

if(in_array("tidak memenuhi syarat",$array_cek)){
    echo '<script language="javascript">alert("Jumlah Kuantitas per Item ada yang melebihi 4 (satuan)");
document.location="index.php?p=formpesan";</script>';
} else {


    $query_cek_eksis_v2 = mysqli_query($koneksi,"select count(id_sementara) as jumlah from 
sementara where unit='$_SESSION[username]'
and user_id='$_SESSION[user_id]' and tgl_permintaan='$tgl_sekarang'");
    $jumlah = mysqli_fetch_assoc($query_cek_eksis_v2);

    if($jumlah['jumlah']==0){
        echo '<script language="javascript">alert("Tidak ada permintaan data");
document.location="index.php?p=formpesan";</script>';
    } else {
        $queryJenis = mysqli_query($koneksi, "UPDATE sementara set status_acc='Pengajuan Kasub' where
id_subbidang=$_SESSION[subbidang_id] and user_id=$_SESSION[user_id] and status_acc='Permintaan Baru'");


        //metode kirim email
        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com"; //host email
//$mail->SMTPDebug = 2;
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->Username = "senderforemail340@gmail.com"; //user email
        $mail->Password = "mtklbsimtazfowfi"; //password email
        $mail->SetFrom("senderforemail340@gmail.com", "Permintaan Barang ".$get_jabatan_detail_pengirim." ".$get_nama_subbidang_pengirim); //set email pengirim
        $mail->Subject = "Permintaan Barang ".$get_jabatan_detail_pengirim." ".$get_nama_subbidang_pengirim; //subyek email
        $mail->AddAddress($get_email_tujuan);  // email tujuan
        $mail->MsgHTML("Halo, " . $get_jabatan_detail_tujuan ." ".$get_nama_subbidang_tujuan." Terdapat Permintaan Barang dari "
            . $get_jabatan_detail_pengirim ." ".$get_nama_subbidang_pengirim.
            ", pada tanggal " . tanggal_indo($tgl_sekarang) . ",  segera cek aplikasi SIBAPER melalui akun Anda"); //pesan

        if ($queryJenis && $mail->Send()) {
            echo '<script language="javascript">alert("Pemberitahuan berhasil !!!");
document.location="index.php?p=formpesan_table";</script>';
        } else {
            echo 'error' . mysqli_error($koneksi);
        }
    }
//    $queryJenis = mysqli_query($koneksi, "UPDATE sementara set status_acc='Pengajuan Kasub' where
//id_subbidang=$_SESSION[subbidang_id] and user_id=$_SESSION[user_id] and status_acc='Permintaan Baru'");
//
//
//    //metode kirim email
//    $mail = new PHPMailer;
//    $mail->IsSMTP();
//    $mail->SMTPSecure = "ssl";
//    $mail->Host = "smtp.gmail.com"; //host email
////$mail->SMTPDebug = 2;
//    $mail->Port = 465;
//    $mail->SMTPAuth = true;
//    $mail->Username = "senderforemail340@gmail.com"; //user email
//    $mail->Password = "mtklbsimtazfowfi"; //password email
//    $mail->SetFrom("senderforemail340@gmail.com","Permintaan Baru"); //set email pengirim
//    $mail->Subject = "Permintaan Baru"; //subyek email
//    $mail->AddAddress($get_email_tujuan);  // email tujuan
//    $mail->MsgHTML("Halo, ".$get_nama_lengkap_penerima."
//    Terdapat Permintaan Barang dari ".$_SESSION['nama_lengkap'].
//        ", pada tanggal ".tanggal_indo($tgl_sekarang).",  segera cek aplikasi SIBAPER melalui akun Anda"); //pesan
//
//    if ($queryJenis && $mail->Send()) {
//        echo '<script language="javascript">alert("Pemberitahuan Kasub berhasil !!!");
//document.location="index.php?p=formpesan_table";</script>';
//    } else {
//        echo 'error' . mysqli_error($koneksi);
//    }
}

//-----------------------------------------------------

//ini query nya dia ngeblast langsung
//$queryJenis = mysqli_query($koneksi, "UPDATE sementara set status_acc='Pengajuan Kasub' where
//id_subbidang=$_SESSION[subbidang_id] and user_id=$_SESSION[user_id] and status_acc='Permintaan Baru'");
//
//
//            if ($queryJenis) {
//                echo '<script language="javascript">alert("Pemberitahuan Kasub berhasil !!!"); document.location="index.php?p=formpesan";</script>';
//            } else {
//                echo 'error' . mysqli_error($koneksi);
//            }






?>
