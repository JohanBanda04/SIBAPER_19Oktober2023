
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
} else if ($page=="history_kasub_operator") {
    include_once "history_kasub_operator.php";
} else if ($page=="detilpermintaan_history_kasuboperator") {
    include_once "detilpermintaan_history_kasuboperator.php";
}else if ($page=="alasan_tidak_setuju_kasub_operator_view") {
    include_once "alasan_tidak_setuju_kasub_operator_view.php";
}else if ($page=="datapermintaan_table") {
    include_once "datapermintaan_table.php";
}else if ($page=="detilpermintaan_table") {
    include_once "detilpermintaan_table.php";
}else if ($page=="history_kasub_operator_table") {
    include_once "history_kasub_operator_table.php";
}else if ($page=="detilpermintaan_history_kasuboperator_table") {
    include_once "detilpermintaan_history_kasuboperator_table.php";
}else if ($page=="data_user_view_kasub_operator") {
    include_once "data_user_view_kasub_operator.php";
}


?>

