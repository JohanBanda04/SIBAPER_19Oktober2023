<?php

unset($_SESSION['login']);
//session_destroy();
session_start();
session_destroy();
header("location:index.php");

?>