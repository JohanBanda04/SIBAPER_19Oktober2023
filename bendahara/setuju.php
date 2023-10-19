<?php

include "../fungsi/koneksi.php";

if (isset($_GET['id']) && isset($_GET['unit']) && isset($_GET['tgl'])) {
    $id = $_GET['id'];
    $tanggal = date('Y-m-d');

    $unit = $_GET['unit'];
    $tgl = $_GET['tgl'];

    $query1 = mysqli_query($koneksi, "UPDATE permintaan SET status=1 WHERE id_permintaan='$id' ");
//
    $query2 = mysqli_query($koneksi, "SELECT * FROM permintaan WHERE id_permintaan='$id'");

    $getData = mysqli_query($koneksi, "SELECT * FROM permintaan WHERE id_permintaan='$id'");
    if(mysqli_num_rows($getData)){
        $getJml = 0;
        while($dt=mysqli_fetch_assoc($getData)){
            $getJml += $dt['jumlah'];
            $kd_brg += $dt['kode_brg'];
            $unit = $dt['unit'];
        }
        $getJumlah += $getJml;
    }

    echo $getJumlah;
    //disini utk kolom unit pada tabel pengeluaran blm masuk
    $query3 = mysqli_query($koneksi, "INSERT INTO pengeluaran (unit, kode_brg, jumlah, tgl_keluar)
		VALUES ('$unit', '$kd_brg', '$getJumlah', '$tanggal' ) ");

    if ($query3) {
//        header("location:index.php?p=datapermintaan&tgl=$tgl&unit=$unit");
        header("location:index.php?p=detilpermintaan&unit=$unit&tgl=$tgl");
    } else {
        echo "ada yang salah" . mysqli_error($koneksi);
    }


//
//    $row = mysqli_fetch_assoc($query2);
//
//    $query3 = mysqli_query($koneksi, "INSERT INTO pengeluaran (unit, kode_brg, jumlah, tgl_keluar)
//		VALUES ('$row[unit]', '$row[kode_brg]', '$row[jumlah]', '$tanggal' ) ");
//
//    if($query3) {
//        header("location:index.php?p=datapermintaan&tgl=$tgl&unit=$unit");
//    } else {
//        echo "ada yang salah" . mysqli_error($koneksi);
//    }
}


?>

<?php echo $id ?>
