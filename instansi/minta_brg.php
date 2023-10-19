<?php

include "../fungsi/koneksi.php";

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "UPDATE sementara Set status_acc='Pengajuan Bendahara' where id_sementara=$id ");

    if($query) {
        header("Location:index.php?p=formpesan");
    }
}


?>