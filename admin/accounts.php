<?php
	if (!isset($_SESSION)) {session_start();}
	isset($_SESSION['request-accounts']) or die('Direct access not permitted!');
    
	$accounts = array();
	
	$accounts['StudioStein'] =  array(
		"nome" => "Studio Stein",
		"initials" => "SS",
		"password" => "a33cd1109cfb6c5ee4a8f1769a69fcf4",
		"type" => ["analytics","forms","master"]);
		
	$accounts['client'] = array(
		"nome" => "Cliente",
		"initials" => "CL",
		"password" => "a33cd1109cfb6c5ee4a8f1769a69fcf4",
		"type" => ["analytics","forms"]);
	
	unset($_SESSION["request-accounts"]);
?>