<?php

session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

if (isset($_POST['alasan_tidak_setuju_kasub_operator'])) {

    $id_sementara = $_POST['id_sementara'];
    $unit = $_POST['unit'];
    $user_id = $_POST['user_id'];
    $tgl_permintaan = $_POST['tgl_permintaan'];
    echo "<script>window.location='index.php?p=alasan_tidak_setuju_kasub_operator_view&unit=$_POST[unit]&id_sementara=$_POST[id_sementara]&user_id=$_POST[user_id]&tgl_permintaan=$_POST[tgl_permintaan]'</script>";

}

?>


