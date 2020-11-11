<?php

// ------------
// Master Class
// ------------

	
	// Arquivo
	function file_read($fileDir) {
		
		if (file_exists($fileDir)) { // Se o arquivo existe, envia as informações em Obj
			$file = fopen($fileDir, "r") or die("Unable to open file!");
			$json = fread($file, filesize($fileDir));
			fclose($file);
			return json_decode($json);
		} else { // Se não, envia false
			return false;
		}
		
	}
	
	function user_permission($perm) {
		if (!isset($_SESSION['login'])) {
			header('LOCATION:login.php'); 
			die();
		}
		
		if (!in_array($perm,$_SESSION["login"]["type"])) {
			header('LOCATION:login.php');
			die();
		}
	}
	
	function check_logout() {
		if(isset($_GET['logout'])) {
			unset($_SESSION["login"]); 
			unset($_GET);
			header('LOCATION:login.php');
			die();
		}
	}

?>