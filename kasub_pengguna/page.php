
<?php

$page = isset($_GET['p']) ? $_GET['p'] : "";

if ($page=="") {
    include_once "main.php";
} else if ($page=="datapermintaan") {
    include_once "datapermintaan.php";
} else if ($page=="datapengeluaran") {
    include_once "datapengeluaran.php";
} else if ($page=="detilpermintaan") {
    include_once "detilpermintaan.php";
} else if ($page=="history_kasub") {
    include_once "history_kasub.php";
} else if ($page=='detilhistory'){
    include_once "detilhistory.php";
} else if ($page=='detailpermintaan_staf'){
    include_once "detailpermintaan_staf.php";
} else if ($page=='detilpermintaan_history_kasubpengguna'){
    include_once "detilpermintaan_history_kasubpengguna.php";
}else if ($page=='alasan_tidak_setuju'){
    include_once "alasan_tidak_setuju.php";
}else if ($page=='datapermintaan_table'){
    include_once "datapermintaan_table.php";
}else if ($page=='history_kasub_table'){
    include_once "history_kasub_table.php";
}else if ($page=='detilpermintaan_history_kasubpengguna_table'){
    include_once "detilpermintaan_history_kasubpengguna_table.php";
}else if ($page=='detilpermintaan_table'){
    include_once "detilpermintaan_table.php";
}else if ($page=='alasan_tidak_setuju_table'){
    include_once "alasan_tidak_setuju_table.php";
}else if ($page=='data_user_view_kasub_pengguna'){
    include_once "data_user_view_kasub_pengguna.php";
}




?>

