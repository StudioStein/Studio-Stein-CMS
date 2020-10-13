<?php if (!isset($_SESSION)) {session_start();} if (!isset($_SESSION['login'])) {header('LOCATION:../login.php'); die();} 
	
	// User Permission
	if ($_SESSION["user-type"]["analytics"] == 0) {header('LOCATION:../dashboard.php'); die();}
	// ---------------
	
	if (!isset($_GET["user"])) { die("No parameter or wrong parameter is used! Go back."); }
	
	$file = fopen("stats.json", "r") or die("Unable to open file!");
	$json = fread($file,filesize("stats.json"));
	fclose($file);
	$obj = json_decode($json);

	
	//get all data from user
	$user = number_format($_GET['user']);
	$userData = [];
	
	for($x = 0; $x < count($obj->data); $x++) {
		if ($obj->data[$x][1] == $user) { $userData[] = $obj->data[$x]; }
	}
	//check if any activity
	if (!count($userData) > 0) { die("User doesnt exists. Go back."); }
		
	date_default_timezone_set("America/Sao_Paulo");
?>

<html>
	<head>
	
		<title>Estatísticas - Studio Stein</title>
		
	</head>
	
	<body>
	
		<h1>Estatísticas</h1>
		
		<h3>Usuário <?php echo $user; ?></h3>
		
		<style>
			table, th, td {
			  border: 1px solid black;
			  border-collapse: collapse;
			}
			
			td { padding: 8px 12px; }
		</style>
		
		<?php
				
		
		
		//save how many sections user have
		$userSections = number_format($userData[count($userData)-1][2]);
		echo "<p>".$userSections." Sessões</p>";
		
		//Show user info if have
		if (isset($obj->userdata->$user)) { 
			echo "<h3>Informações</h3>";
			
			$userinfo = $obj->userdata->$user;
			
			foreach($userinfo as $x) {
				foreach($x as $y => $y_value) {
					echo "<p>".$y.": ".$y_value."</p>";
				}
				echo "<p><b>---</b></p>";
			}
			
			
		}
		
		//display each section
		echo "<h3>Sessões</h3>";
		
		
		$dispositivo = $ip = "";
		
		for($x = 1; $x <= $userSections; $x++) {
			
			echo "<h4>Sessão ".$x."</h4>";
			echo "<p>Usuário entrou no site.</p>";
			
			echo "<table><tr><td><b>Horário</b></td><td><b>Página</b></td></tr>";
			
			for($y = 0; $y < count($userData); $y++) {
				if (number_format($userData[$y][2]) == $x) {
					echo "<tr><td>".date("d.m.Y - H:i:s", $userData[$y][0])."</td><td>".$userData[$y][3]."</td></tr>";
					$dispositivo = $userData[$y][4];
					$ip = $userData[$y][5];
				}
			}
			
			$details = json_decode(file_get_contents("http://ipinfo.io/".$ip."/json"));
			
			echo "</table>";
			echo "<p>Dispositivo: ".$dispositivo."</p>";
			if (isset($details->city)) { echo "<p>Localização: ".$details->city.", ".$details->region.", ".$details->country."</p>"; }
			echo "<p>Usuário saiu do site.</p><hr>";
			
		}
		
			?>
		</table>
		
	</body>
	
</html>