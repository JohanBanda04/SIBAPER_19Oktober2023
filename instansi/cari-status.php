<?php
//proses
session_start();
include "../fungsi/koneksi.php";
if (isset($_POST['caristatus'])) {

    $_SESSION['filter_status'] = $_POST['cari_status'];
    $cari_status = $_POST['cari_status'];


    header("location:index.php?p=formpesan&status=$cari_status");

}
?>


