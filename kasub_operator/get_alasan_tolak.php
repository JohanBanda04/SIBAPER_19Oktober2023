<?php

include "../fungsi/koneksi.php";

$alasan_tolak = $_POST['alasan_tolak'];

echo $alasan_tolak;

//$query = mysqli_query($koneksi,"select sisa-(select sum(jumlah) from sementara sa
//where sa.kode_brg=sb.kode_brg) as sisa_dummy, kode_brg from stokbarang sb WHERE kode_brg='$kode_brg'");
//
//
//
//if (mysqli_num_rows($query)) {
//    $row = mysqli_fetch_assoc($query);
//    if($row['sisa_dummy']!=null){
//        echo $row['sisa_dummy'];
//
//    } else if($row['sisa_dummy']==null){
//        $querys = mysqli_query($koneksi,"select * from stokbarang sb WHERE kode_brg='$kode_brg'");
//        if(mysqli_num_rows($querys)){
//            $ro = mysqli_fetch_assoc($querys);
//            echo $ro['sisa'];
//        }
//    }
//}

?>