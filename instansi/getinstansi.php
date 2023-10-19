<?php  

include "../fungsi/koneksi.php";

$username = $_POST['username'];

$query = mysqli_query($koneksi,"select * from user WHERE username='".mysqli_escape_string($conn, $_POST['username'])."'");

if (mysqli_num_rows($query)) {
	$row = mysqli_fetch_assoc($query);
	echo $row['jabatan'];
}

?>