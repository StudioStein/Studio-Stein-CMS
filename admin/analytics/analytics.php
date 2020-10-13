<?php
	date_default_timezone_set("America/Sao_Paulo");
	
	// Abre o JSON para leitura
	$file = fopen("admin/analytics/stats.json", "r") or die("Unable to open file!");
	$json = fread($file,filesize("admin/analytics/stats.json"));
	$obj = json_decode($json);
	
	// Caso o Cookie não tenha sido criado, cria e adiciona os valores da sessão na Array
	$user = 0;
	if(!isset($_COOKIE["user"])) {
		$user = $obj->userid+1;
		setcookie("user", $user, time() + (86400 * 365), "/");
		$obj->userid += 1;
		
	} else {
		$user = $_COOKIE["user"];
		setcookie("user", $user, time() + (86400 * 365), "/");
	}
	
	// Verifica a sessão
	$section = 0;
	$sectionLength = 4; // Quantas horas dura uma sessão
	
	if(!isset($_COOKIE["sectionNum"])) {
		setcookie("sectionNum", 1, time() + (86400 * 365), "/");
		setcookie("sectionOpen", 1, time() + (3600 * $sectionLength), "/");
		$section = 1;
	} else {
		if(!isset($_COOKIE["sectionOpen"])) {
			$section = $_COOKIE["sectionNum"]+1;
			setcookie("sectionOpen", 1, time() + (3600 * $sectionLength), "/");
			setcookie("sectionNum", $section, time() + (86400 * 365), "/");
		} else {
			$section = $_COOKIE["sectionNum"];
			setcookie("sectionNum", $section, time() + (86400 * 365), "/");
		}
	}
	
	// Detecta o dispositivo
	include 'admin/analytics/Mobile_Detect.php';
	$detect = new Mobile_Detect();
	$device = "";
	
	if ( $detect->isMobile() ) {
		
		if($detect->isiOS()) {
			$device = "Mobile - iOS";
		} else if( $detect->isAndroidOS() ){
			$device = "Mobile - Android";
		} else { $device = "Mobile - Outro"; }
		
	} else if( $detect->isTablet() ){
		
		if( $detect->isiOS() ){
			$device = "Tablet - iOS";
		} else if( $detect->isAndroidOS() ){
			$device = "Tablet - Android";
		} else { $device = "Tablet - Outro"; }
		
	} else { $device = "Desktop"; }
	
	
	// Adiciona a sessão na array
	$array = array(time(), $user, $section, parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), $device, $_SERVER['REMOTE_ADDR']);
	
	$obj->data[] = $array;
	
	fclose($file); // Fecha o arquivo para leitura e abre para escrita (em modo "w" que apaga todo o conteúdo e escreve do zero)
	
	$file = fopen("admin/analytics/stats.json", "w") or die("Unable to open file!");
	fwrite($file, json_encode($obj));
	fclose($file);
?>