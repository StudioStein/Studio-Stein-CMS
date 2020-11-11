<?php

// ---------------
// Analytics Class
// ---------------

class userAnalytics {
	public $user;
	public $section;
	public $sectionDuration;
	  
	// Start
	function __construct() {
		$this->sectionDuration = 60; //Em minutos
		
		// Funções
		$obj = $this->file_read("admin/data_analytics/status.json"); //Ler dados gerais
		$obj = $this->set_user($obj); //Define o usuário e cookies de usuário
		$obj = $this->set_section($obj); //Define a sessão, cookies de sessão e atualiza o numero de acessos

		$this->file_write("admin/data_analytics/status.json",$obj); //Escrever dados gerais
		
		$this->data_write($obj->acessos); //Escrever dados específicos
		
	}
	
	
	// Arquivo
	function file_read($fileDir) {
		
		if (file_exists($fileDir)) { // Se o arquivo existe, envia as informações em Obj
			$file = fopen($fileDir, "r") or die("Unable to open file!");
			$json = fread($file, filesize($fileDir));
			fclose($file);
			return json_decode($json);
		} else { // Se não, envia um obj vazio
			return json_decode("{}");
		}
		
	}
	
	function file_write($fileDir,$value) {
		
		$file = fopen($fileDir, "w") or die("Unable to open file!");
		fwrite($file, json_encode($value));
		fclose($file);
		
	}
	
	// User
	function set_user($obj) {
		
		if(isset($_COOKIE["user"])) {
			$this->user = $_COOKIE["user"];
			setcookie("user", $this->user, time() + (86400 * 365), "/");
		} else {
			if(isset($obj->users)) {
				$obj->users += 1;
			}
			else {
				$obj->users = 1;
			}
			$this->user = $obj->users;
			setcookie("user", $this->user, time() + (86400 * 365), "/");
			
		}
		
		return $obj;
		
	}
	
	// Section
	function set_section($obj) {
		
		if(isset($_COOKIE["sectionNum"])) {
			if(isset($_COOKIE["sectionOpen"])) {
				$this->section = $_COOKIE["sectionNum"];
				setcookie("sectionOpen", 1, time() + (60 * $this->sectionDuration), "/");
				setcookie("sectionNum", $this->section, time() + (86400 * 365), "/");
			} else {
				$this->section = $_COOKIE["sectionNum"]+1;
				setcookie("sectionOpen", 1, time() + (60 * $this->sectionDuration), "/");
				setcookie("sectionNum", $this->section, time() + (86400 * 365), "/");
			}
		} else {
			setcookie("sectionNum", 1, time() + (86400 * 365), "/");
			setcookie("sectionOpen", 1, time() + (60 * $this->sectionDuration), "/");
			$this->section = 1;
		}
		
		if (isset($obj->acessos)) {
			$obj->acessos += 1;
		}
		else {
			$obj->acessos = 1;
		}
		
		return $obj;
		
	}
	
	// Detectar Dispositivo
	function getDevice() {
		
		include 'admin/user/mobileDetect.php';
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
		
		return $device;
		
	}
	
	// Escrever dados de sessão
	function data_write($total) {
		
		$fileDir = ceil($total/1000);
		$obj = $this->file_read("admin/data_analytics/".$fileDir.".json"); //Ler dados do ultimo arquivo
		
		$array = array(time(), $this->user, $this->section, parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), $this->getDevice(), $_SERVER['REMOTE_ADDR']);
		
		if (isset($obj->acessos)) {
			$obj->acessos[] = $array;
		}
		else {
			$obj->acessos = array();
			$obj->acessos[] = $array;
		}
		
		$this->file_write("admin/data_analytics/".$fileDir.".json", $obj); //Ler dados do ultimo arquivo
		
	}

	
}

?>