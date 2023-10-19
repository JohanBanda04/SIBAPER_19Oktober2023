<?php
session_start();
include "../fungsi/koneksi.php";
$tgl_sekarang = date('Y-m-d');

if(isset($_POST['hapus_yg_tidak_disetujui'])){

    $hapus_yg_tidak_disetujui = $_POST['hapus_yg_tidak_disetujui'];
    echo $hapus_yg_tidak_disetujui;




}



?>