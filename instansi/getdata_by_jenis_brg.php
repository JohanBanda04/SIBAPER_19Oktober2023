<?php

include "../fungsi/koneksi.php";

$id = $_POST['jenis'];

// metode pengambilan data ajax berdasarkan value dari selected option
if ($id == 'semua_jenis_brg') {
    echo "<option value='semua_nama_brg'>Semua Nama Barang</option>\n";
} else if ($id == 'pilih_jenis_barang') {
    echo "<option value='pilih_nama_barang'>--Pilih Nama Barang--</option>\n";
    echo "<option value='semua_nama_brg'>Pilih Nama Barang</option>\n";
} else {
    $query = mysqli_query($koneksi, "select * from stokbarang WHERE id_jenis='$id'");

    if (mysqli_num_rows($query)) {
        $jml_data = mysqli_num_rows($query);
//        echo "<option>--Pilih Barang--</option>";
//    	echo "<option>$jml_data</option>";
        while ($row = mysqli_fetch_assoc($query)) {

            echo "<option value=$row[kode_brg]>$row[nama_brg]</option>\n";

        }
    }
}


//$query = mysqli_query($koneksi,"select * from stokbarang WHERE id_jenis='$id'");
//
//if (mysqli_num_rows($query)) {
//    $jml_data = mysqli_num_rows($query);
//    echo "<option>--Pilih Barang--</option>";
////    	echo "<option>$jml_data</option>";
//    while($row=mysqli_fetch_assoc($query)){
//
//        echo "<option value=$row[kode_brg]>$row[nama_brg]</option>\n";
//
//    }
//}

?>