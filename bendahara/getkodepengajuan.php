<?php  

	include "../fungsi/koneksi.php";

	$kode_brg = $_POST['kode'];

	$query = mysqli_query($koneksi,"select * from stokbarang WHERE kode_brg='$kode_brg'");
    
    if (mysqli_num_rows($query)) {
    	$row = mysqli_fetch_assoc($query);

        $a=array(
            "stok"=>$row['stok'],
            "sisa"=>$row['sisa'],
        );

//    	echo $row['stok'];
    	echo json_encode($a);
    }
  
?>