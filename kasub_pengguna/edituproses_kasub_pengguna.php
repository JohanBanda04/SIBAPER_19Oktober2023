<?php
session_start();
include '../fungsi/koneksi.php';
include '../fungsi/fungsi.php';

if(isset($_POST['simpan'])){

    $user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $nama_lengkap = $_POST['nama_lengkap'] ;
    $nip = $_POST['nip'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    echo $user_id."::";
    echo $username."::";
    echo $nama_lengkap."::";
    echo $nip."::";
    echo $password."::";
    echo $email."::";

    $query_get_password_old = mysqli_query($koneksi,"select * from user where id_user='$_SESSION[user_id]'");

    $dt_user_password = mysqli_fetch_assoc($query_get_password_old);
    $old_password = $dt_user_password['password'];

    if($_POST['password']==$old_password){
        $password = $_POST['password'];
    } else {
        $password = md5($_POST['password']);
    }

//    username, nama lengkap, nip, password, email

    $query_update_data = mysqli_query($koneksi,"update user set username='$username',
nama_lengkap='$nama_lengkap',nik='$nip',password='$password',email='$email' where id_user='$_SESSION[user_id]'");

    if($query_update_data){
        echo "<script>window.alert('Data Berhasil Disimpan')
		window.location='index.php?p=data_user_view_kasub_pengguna&pa=data_users_kasub_pengguna'</script>";
    } else {
        echo "gagal euy cuy" . mysqli_error($koneksi);
    }

}

?>