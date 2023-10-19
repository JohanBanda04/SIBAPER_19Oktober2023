<?php  

include "../fungsi/koneksi.php";

if(isset($_POST['update'])) {
	$id = $_POST['id'];

	$query_cari_password = mysqli_query($koneksi,"select * from `user` where id_user='$id'");
	while($d = mysqli_fetch_array($query_cari_password)){
	    $password_old = $d['password'];
    }
	
//	$username = $_POST['username'];
//	$jabatan = $_POST['jabatan'];
//    $level = $_POST['level'];


    $username = $_POST['username'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $nip = $_POST['nip'];

    if($_POST['password']==$password_old){
        $password = $_POST['password'];
    } else if($_POST['password']!=$password_old){
        $password = md5($_POST['password']);

    }
    $level = $_POST['level'];
    $jabatan = $_POST['jabatan'];
    $subbidang_id = $_POST['subbidang_id'];
    $email = $_POST['email'];
	
//	echo $password_old;

//	$query_old = mysqli_query($koneksi, "UPDATE user SET username='$username', jabatan='$jabatan', level='$level' WHERE id_user ='$id' ");
	$query = mysqli_query($koneksi, "UPDATE user SET
username='$username', nama_lengkap='$nama_lengkap',nik='$nip',
password='$password',level='$level', jabatan='$jabatan',subbidang_id='$subbidang_id',
email='$email'
WHERE id_user ='$id'");

	if ($query) {
		echo '<script language="javascript">alert("Data Berhasil Di Ubah !!!"); 
        document.location="index.php?p=user";</script>';
	} else {
		echo 'error' . mysqli_error($koneksi);
	}

}



?>