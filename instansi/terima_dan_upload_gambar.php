<?php
session_start();
include "../fungsi/koneksi.php";
include "../fungsi/fungsi.php";

$id_sementara= isset($_GET['id_sementara'])? $_GET['id_sementara']:'';

echo $_GET['id_sementara'];
?>