<?php

// -----------
// Forms Class
// -----------

class userForms {
	public $data;
	
	// Start
	function __construct() {
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") { // Se o request for POST

			$this->data = $this->clear_array($_POST); // Guarda as informações já limpas
			
			$obj = $this->file_read("admin/data_forms/status.json"); //Ler dados gerais
			
			if(isset($obj->total)) {
				$obj->total += 1;
			}
			else {
				$obj->total = 1;
			}
			
			$this->file_write("admin/data_forms/status.json",$obj); // Escrever dados gerais
			
			$fileDir = ceil($obj->total/1000);
			$obj = $this->file_read("admin/data_forms/".$fileDir.".json"); //Ler dados do ultimo arquivo
			
			$this->data["time"] = time();
			$this->data["user"] = $_COOKIE["user"];
			$this->data["section"] = $_COOKIE["sectionNum"];
			unset($this->data["submit"]);
		
			if (isset($obj->submits)) {
				$obj->submits[] = $this->data;
			}
			else {
				$obj->submits = array();
				$obj->submits[] = $this->data;
			}
			
			$this->file_write("admin/data_forms/".$fileDir.".json", $obj); //Ler dados do ultimo arquivo
			
			/* MODULAR: SEND EMAIL
			$this->data["time"] = date("d.m.Y - H:i:s", $this->data["time"]);
			$conteúdo = "<center><h3>NOVO CONTATO</h3><h1>Vlink Internet</h1><hr><br>";
			foreach($this->data as $x => $x_val) {
				$conteúdo .= "<p><b style='text-transform:uppercase;'>".$x."</b><br>".$x_val."</p><br>";
			}
			$conteúdo .= "<br><hr><a href='http://vlink.tec.br/admin/user.php?user=".$_COOKIE["user"]."'>DADOS DO USUÁRIO</a></center>";
			
			if ($this->send_email("website@vlink.tec.br", "sac@vlink.tec.br", "Novo contato - ".$this->data["form"]." - Vlink", $conteúdo)) {
				// Destino depende do formulário
				if ($this->data["form"] == "WhatsApp") {
					header('LOCATION:https://api.whatsapp.com/send?phone=554933400040'); die();
				} else {
					header('LOCATION:index.php'); die();
				}
			} else {
				echo "Email not sent";
			}
			*/
		}
		
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
	
	// Email
	function send_email($emailRemetente, $emailDestinatario, $assunto, $corpo) {
		
		$email_headers = implode ( "\n",array ( "From: $emailRemetente", "Reply-To: $emailRemetente", "Return-Path: $emailRemetente","MIME-Version: 1.0","X-Priority: 3","Content-Type: text/html; charset=UTF-8" ) );
		if (mail ($emailDestinatario, $assunto, nl2br($corpo), $email_headers)){ 
			return true;
		} else { 
			return false;
		}
		
	}
	
	// Testar dados;
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	function clear_array($data) {
		foreach($data as $x => $x_val) {
			$data[$x] = $this->test_input($x_val);
		}
		return $data;
	}
	
}

?>