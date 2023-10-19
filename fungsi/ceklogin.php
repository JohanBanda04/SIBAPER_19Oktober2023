<?php  
// ORI
	if (isset($_SESSION['login'])) {
		if ($_SESSION['level'] == "instansi") {
			header("location:instansi/index.php");
		} else if ($_SESSION['level'] == "bendahara"){
			header("location:bendahara/index.php");
		} else if ($_SESSION['level'] == "it"){
			header("location:it/index.php");
		}else if ($_SESSION['level'] == "pengguna"){
            header("location:instansi/index.php");
		}else if ($_SESSION['level'] == "kasub_pengguna"){
            header("location:kasub_pengguna/index.php");
		} else if ($_SESSION['level'] == "operator"){
            header("location:bendahara/index.php");
		}else if ($_SESSION['level'] == "kasub_operator"){
            header("location:kasub_operator/index.php");
		} else {
			header("location:index.php");
		}
	}

//DIRUBAH JOHAN
//	if (isset($_SESSION['login'])) {
//		if ($_SESSION['level'] == "instansi") {
//			header("location:index.php");
//		} else if ($_SESSION['level'] == "bendahara"){
//			header("location:index.php");
//		} else if ($_SESSION['level'] == "it"){
//			header("location:index.php");
//		} else {
//			header("location:index.php");
//		}
//	}

?>