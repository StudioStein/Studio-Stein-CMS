<?php
	if (!isset($_SESSION)) {session_start();}
    if(isset($_SESSION['login'])) {
        header('LOCATION:dashboard.php'); die();
    } else {
		header('LOCATION:login.php'); die();
	}
?>