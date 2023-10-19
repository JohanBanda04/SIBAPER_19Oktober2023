<?php
session_start();
include "../fungsi/koneksi.php";
$tgl_sekarang = date('Y-m-d');

if(isset($_POST['edit_yg_tidak_disetujui'])){

    $edit_yg_tidak_disetujui = $_POST['edit_yg_tidak_disetujui'];
    echo $edit_yg_tidak_disetujui."edit";




}



?>