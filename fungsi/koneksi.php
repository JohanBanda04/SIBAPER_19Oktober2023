<?php  

$host = "localhost";
//$database = "sibaper_api";
$database = "sibaper_test";
$username = "root";
$password = "";

$koneksi = mysqli_connect($host, $username, $password, $database);
//$koneksi = mysqli_real_escape_string($host, $username, $password, $database);

if (!$koneksi) {
	echo "Koneksi gagal " . mysqli_connect_error();
}

?>