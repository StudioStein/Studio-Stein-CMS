<?php

	date_default_timezone_set("America/Sao_Paulo");
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		//Tenta abrir o arquivo, se não conseguir cria o obj sozinho
		if (file_exists("admin/forms/formsubmissions.json")) {
			$file = fopen("admin/forms/formsubmissions.json", "r") or die("Unable to open file!");
			$json = fread($file,filesize("admin/forms/formsubmissions.json"));
			fclose($file);
			$obj = json_decode($json);
		} else { $obj = []; }
		
		//Salva todos os dados do submit
		$data = $_POST;
		$data["time"] = time();
		$obj[] = $data;
		
		
		//Salva o arquivo
		$file = fopen("admin/forms/formsubmissions.json", "w") or die("Unable to open file!");
		fwrite($file, json_encode($obj));
		fclose($file);
		
		//Salva os dados do usuario
		if(isset($_COOKIE["user"])) {
			
			//Open file
			$file = fopen("admin/analytics/stats.json", "r") or die("Unable to open file!");
			$json = fread($file,filesize("admin/analytics/stats.json"));
			$obj2 = json_decode($json);
			
			//write array with good information
			$gooddata = array("form" => $_POST['submit']);
			foreach($_POST as $x => $x_val) {
				if ($x == "name"
					or $x == "email" 
					or $x == "tel" 
					or $x == "whatsapp") {
						$gooddata[$x] = $x_val;
					}
			}
			
			if (isset($obj2->userdata->$_COOKIE["user"])) {
				$userdata = $obj2->userdata->$_COOKIE["user"];
				$userdata[] = $gooddata;
				$obj2->userdata->$_COOKIE["user"] = $userdata;
			} else {
				$obj2->userdata->$_COOKIE["user"] = [$gooddata];
			}
			
			//write file
			$file = fopen("admin/analytics/stats.json", "w") or die("Unable to open file!");
			fwrite($file, json_encode($obj2));
			fclose($file);
			
		}
		
		
	} else { die(); }

?>