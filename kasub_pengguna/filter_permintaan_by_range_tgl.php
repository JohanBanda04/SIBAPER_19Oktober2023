<?php
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

if(isset($_POST["tampilkan"])){
    $tanggala = $_POST["tanggala"];
    $tanggalb = $_POST["tanggalb"];

    echo $tanggala."-".$tanggalb;
}
?>