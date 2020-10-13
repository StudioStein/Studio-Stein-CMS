<?php
	if (!isset($_SESSION)) {session_start();}
	isset($_SESSION['request-accounts']) or die('Direct access not permitted!');
    
	$accounts = array();
	
	$accounts['StudioStein'] =  array(
		"nome" => "Matheus Stein",
		"password" => "a33cd1109cfb6c5ee4a8f1769a69fcf4",
		"type" => [
			"analytics" => 1]);
		
	$accounts['client'] = array(
		"nome" => "Cliente",
		"password" => "e8d95a51f3af4a3b134bf6bb680a213a",
		"type" => [
			"analytics" => 0]);
	
	unset($_SESSION["request-accounts"]);
?>