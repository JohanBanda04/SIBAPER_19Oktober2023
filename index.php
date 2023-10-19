<?php
session_start();

include "fungsi/koneksi.php";
include "fungsi/ceklogin.php";


//cek agar stelah logout dan ada back dari browser,tdk bisa akses input data

$err="";

//disini waktu proses pencet tombol login
if(isset($_POST['login'])){
    //echo "submit login" ; die;
	$username = mysqli_real_escape_string($koneksi,$_POST['username']);
	$password = md5($_POST['password']);
//	$password = $_POST['password'];
	$level = $_POST['level'];
//	$jabatan = $_POST['jabatan'];

//	$query = "SELECT * FROM user WHERE username='$username' && password='$password'";
	$query = "SELECT id_user,username,nama_lengkap,nik,password,level,jabatan,subbidang_id 
FROM user WHERE username='$username' && password='$password'";
	$hasil = mysqli_query($koneksi, $query);

	if (!$hasil) {
		echo "ada error";
	}

	if (mysqli_num_rows($hasil) == 0) {
		$err="
		<div class='row' style='margin-top: 15px';>
		<div class='col-md-12'>
		<div class='box box-solid bg-red'>
		<div class='box-header'>
		<h3 class='box-title'>Login Gagal!</h3>
		</div>
		<div class='box-body'>
		<p>Username atau password yang anda masukan salah.</p>
		</div>
		</div>
		</div>
		</div>
		</div>";
	} else {
		$row = mysqli_fetch_array($hasil);

		//echo "<pre>"; print_r($row); die;

		$_SESSION['username'] = $row['username'];
		$_SESSION['jabatan'] = $row['jabatan'];
		$_SESSION['level'] = $row['level'];
		$_SESSION['user_id'] = $row['id_user'];
		$_SESSION['subbidang_id'] = $row['subbidang_id'];
        $_SESSION['filter_status'] = "no";
//		var_dump($_SESSION['username']);
		$_SESSION['nama_lengkap'] = $row['nama_lengkap'];

		if(($row['level'] == "instansi" && $level == "instansi" ) || ($row['level'] == "pengguna" && $level == "pengguna" )) {
			$_SESSION['login'] = true;
			header("location:instansi/index.php");
		} else if ( ($row['level'] == "bendahara" && $level == "bendahara") || ($row['level'] == "operator" && $level == "operator")) {
			$_SESSION['login'] = true;
			header("location:bendahara/index.php");

		} else if (($row['level'] == "it" && $level == "it") || ($row['level']== "it" && $level== "pilih_level")) {
			$_SESSION['login'] = true;
			header("location:it/index.php");

		} else if($row['level']=="kasub_operator" && $level == "kasub_operator"){
            $_SESSION['login'] = true;
            header("location:kasub_operator/index.php");
        } else if($row['level']=="kasub_pengguna" && $level == "kasub_pengguna"){
            $_SESSION['login'] = true;
            header("location:kasub_pengguna/index.php");
        }
        else {
			$err="
			<div class='row' style='margin-top: 15px';>
			<div class='col-md-12'>
			<div class='box box-solid bg-red'>
			<div class='box-header'>
			<h3 class='box-title'>Login Gagal!</h3>
			</div>
			<div class='box-body'>
			<p>Anda salah memilih level login.</p>
			</div>
			</div>
			</div>
			</div>
			</div>";
		}
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sistem Informasi Barang Persediaan</title>
	<!-- Icon  -->
	<link rel="shortcut icon" type="image/icon" href="gambar/SIBAPER-LOGO-MAROON.png">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/bootstrap/css/custom.css" rel="stylesheet">
	<link href="assets/dist/css/AdminLTE.min.css" rel="stylesheet" >
	<link href="assets/plugins/iCheck/square/blue.css" rel="stylesheet">
	<link href="assets/fa/css/font-awesome.min.css" rel="stylesheet">


</head>
<body class="hold-transition login-page" style="background-image: url('gambar/SIBAPER-BACKGROUND4.png');
background-size: cover; background-repeat: no-repeat; background-position: 0vh ; height: 500px">
	<div class="login-box" >
		<div class="login-logo">
		</div><!-- /.login-logo -->
		<div class="login-box-body" style="border-radius: 20px; background: #476a60; opacity: 85%">
<!--			<h3 class="text-center">SiKerang</h3>-->
<!--			<img src="gambar/SiKerang-Icon.png" style="width: 300px; height: 150px;">-->
			<img src="gambar/SIBAPER-LOGO-YELLOW.png" style="width: 190px; height: 100px; border-radius: 20%">
			<img src="gambar/SIBAPER-TITLE5.png" style="width: 300px; height: 70px;">
			<form method="post">
				<div class="form-group">
					<div class="input-group">
						<span style="border-bottom-left-radius: 15px ; border-top-left-radius: 15px ; " class="input-group-addon"><i class="fa fa-user" style="color: orange"></i></span>
						<input style="border-bottom-right-radius: 15px ; border-top-right-radius: 15px ; "
                               type="text" class="form-control" placeholder="Username" name="username" required autofocus />
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span style="border-bottom-left-radius: 15px ; border-top-left-radius: 15px ; " class="input-group-addon"><i class="fa fa-unlock" style="color: #0f74a8"></i></span>
						<input style="border-bottom-right-radius: 15px ; border-top-right-radius: 15px ; " type="password" class="form-control" placeholder="Password" name="password"  required>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span style="border-bottom-left-radius: 15px ; border-top-left-radius: 15px ; " class="input-group-addon"><i class="fa fa-shield" style="color: #0e0e4e; opacity: 80%"></i></span>
						<select style="border-bottom-right-radius: 15px ; border-top-right-radius: 15px ; " class="form-control col-md-5" name="level" required>
                            kasub_pengguna kasub_operator operator pengguna
							<option value="pilih_level">[Pilih Level]</option>
							<option value="kasub_pengguna">Kasi Pengguna</option>
<!--							<option value="kasub_operator">Kasub Operator</option>-->
							<option value="kasub_operator">Kasi Pengelola</option>
<!--							<option value="operator">Operator</option>-->
							<option value="operator">Pengelola</option>
							<option value="pengguna">Pengguna</option>
<!--                            --><?php
//                                $query = mysqli_query($koneksi,"select * from `level` group by nama_level");
//                                while($data = mysqli_fetch_array($query)) { ?>
<!--                                    <option value="--><?php //echo $data['nama_level']; ?><!--">--><?php //echo $data['nama_level']; ?><!--</option>-->
<!--                                --><?php
//                                }
//                                ?>

						</select>
					</div>
				</div>
				<div class="row" style="border-radius: 25px;">
					<div class="col-xs-12" style="border-radius: 20%;">
						<input type="submit" style="background-color:#491015; border-radius: 25px;"
                               class="btn btn-adn btn-block btn-flat pull-right"
                               value="Login" name="login"/>
					</div><!-- /.col -->
				</div>

                <div class="row" style="border-radius: 25px; margin-top: 25px">
                    <div  class="col-xs-12" style="border-radius: 20%; ">
                        <span style="color: black; margin-left: 30px; font-weight: bold">Kantor Imigrasi Kelas II TPI Sumbawa Besar</span>
                    </div><!-- /.col -->
                </div>
			</form>


		</div>
		<?= $err; ?>
      <!-- /.login-box-body
      <div class="row" style="margin-top: 15px;">
	       <div class="col-md-12">
	        	<div class="box box-solid bg-red">
	        		<div class="box-header">
	        			<h3 class="box-title">Gagal Login</h3>
	        		</div>
	        		<div class="box-body">
	        			<p>Username atau password salah</p>
	        		</div>
	        	</div>
	        </div>
        </div>
    </div>
-->
<!-- /.login-box -->

<script src="assets/plugins/jQuery/jquery.min.js" type="text/javascript"></script>
<script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>
