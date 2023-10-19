<?php  

	include "../fungsi/koneksi.php";

	$kode_brg = $_POST['kode'];


	//metode penggunaan status_acc
	$query = mysqli_query($koneksi,"select stokbarang.sisa-(select sum(sementara.jumlah) 
from (sementara inner join stokbarang 
on sementara.kode_brg=stokbarang.kode_brg) where sementara.status_acc in ('Permintaan Baru', 'Pengajuan Kasub', 'setuju', 
'Pengajuan Bendahara', 'Pengajuan Kasub Bendahara', 
'Setuju Kasub Bendahara',  
'Penyerahan Barang Ke Pengguna', 'Penerimaan Barang Dari Bendahara') 
and sementara.kode_brg='$kode_brg') as sisa_dummy,kode_brg from stokbarang where stokbarang.kode_brg='$kode_brg'");

//LANJUT DISINI, ubah query utk dapatkan value sisa barang mengacu dari "status_acc" pada tabel 'sementara'
    
    if (mysqli_num_rows($query)) {
    	$row = mysqli_fetch_assoc($query);
//    	echo $row['stok'];
    	if($row['sisa_dummy']!=null){
            echo $row['sisa_dummy'];

        } else if($row['sisa_dummy']==null){
            $querys = mysqli_query($koneksi,"select * from stokbarang sb WHERE kode_brg='$kode_brg'");
            if(mysqli_num_rows($querys)){
                $ro = mysqli_fetch_assoc($querys);
                echo $ro['sisa'];
            }
        }
    }
  
?>