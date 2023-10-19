 
<?php 
  
    $page = isset($_GET['p']) ? $_GET['p'] : "";

    if ($page == 'formpesan') {
        include_once "formpesan.php";
    } else if ($page=="") {
        include_once "main.php";
    } else if ($page=="datapesanan") {
        include_once "datapesanan.php";
    }  else if ($page=="edit") {
        include_once "editpesan.php";
    } else if ($page=="hapus") {
        include_once "hapuspesan.php";
    } else if($page == "cetakpesanan"){
        include_once "cetakpesan.php";
    } else if($page == "detil"){
        include_once "detilpesan.php";
    } else if($page == "material"){
        include_once "material.php";
    } else if($page == "history_permintaan_barang"){
        include_once "history_permintaan_barang.php";
    }else if($page == "detil_history_permintaan_barang"){
        include_once "detil_history_permintaan_barang.php";
    }else if($page == "terima_barang_dari_bendahara"){
        include_once "terima_barang_dari_bendahara.php";
    }else if($page == "terima_dan_upload_gambar"){
        include_once "terima_dan_upload_gambar.php";
    }else if($page == "detil_history_permintaan_barang_new"){
        include_once "detil_history_permintaan_barang_new.php";
    }else if($page == "terima_barang_dari_bendahara_new"){
        include_once "terima_barang_dari_bendahara_new.php";
    }else if($page == "cetak_bpp_baru"){
        include_once "cetak_bpp_baru.php";
    }else if($page == "history_permintaan_barang_table"){
        include_once "history_permintaan_barang_table.php";
    }else if($page == "detil_history_permintaan_barang_table"){
        include_once "detil_history_permintaan_barang_table.php";
    }else if($page == "cetak_bpp_baru_table"){
        include_once "cetak_bpp_baru_table.php";
    }else if($page == "cetak_bpp_baru_table_v2"){
        include_once "cetak_bpp_baru_table_v2.php";
    }else if($page == "datapesanan_table"){
        include_once "datapesanan_table.php";
    }else if($page == "detil_table"){
        include_once "detil_table.php";
    }else if($page == "formpesan_table"){
        include_once "formpesan_table.php";
    }else if($page == "data_user_view"){
        include_once "data_user_view.php";
    }


 ?>
 
