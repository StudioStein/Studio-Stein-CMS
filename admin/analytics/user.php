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
		
		<link rel="stylesheet" href="../ui/simple-grid.min.css">
		<link rel="stylesheet" href="../ui/balloon.min.css">
		<link rel="stylesheet" href="../ui/ui.css">
		<script src="https://unpkg.com/feather-icons"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
	</head>
	
	<body>
		
		<div class="navbar">
		
			<div class="container">
			 
			  <div class="row">
				<div class="col-6">
					<h1 class="pageTitle">Seu site</h1>
				</div>
				<div class="col-6">
					<div style="margin-top:20px">
						<form method="post" action="../index.php">
							Bem vindo(a), <b><?php echo $_SESSION['user-nome']; ?></b>!
							<label for="logout" class="pointer" aria-label="Logout" data-balloon-pos="down"><i data-feather="power"></i></label>
							<input type='submit' name="logout" id="logout" value="Logout" hidden>
						</form>
					</div>
				</div>
			  </div>
			  
			</div>
		
		</div>
		
		<div>
			<div class="container pageContent">
			
				<p class="breadcrumbs"><b><a href="../index.php">Dashboard</a> <i data-feather="chevron-right"></i> <a href="index.php">Estatísticas</a> <i data-feather="chevron-right"></i> Usuário</p>
				
				<h2><i data-feather="user"></i> Usuário <?php echo $user; ?></h2>
				
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
					
					echo "<div style='overflow-x:auto;'><table><tr><td><b>Horário</b></td><td><b>Página</b></td></tr>";
					
					for($y = 0; $y < count($userData); $y++) {
						if (number_format($userData[$y][2]) == $x) {
							echo "<tr><td>".date("d.m.Y - H:i:s", $userData[$y][0])."</td><td>".$userData[$y][3]."</td></tr>";
							$dispositivo = $userData[$y][4];
							$ip = $userData[$y][5];
						}
					}
					
					$details = json_decode(file_get_contents("http://ipinfo.io/".$ip."/json"));
					
					echo "</table></div>";
					echo "<p>Dispositivo: ".$dispositivo."</p>";
					if (isset($details->city)) { echo "<p>Localização: ".$details->city.", ".$details->region.", ".$details->country."</p>"; }
					echo "<p>Usuário saiu do site.</p><hr>";
					
				}
				
					?>
				
				<p class="footer">dev by <a href="http://studiostein.com.br/" target="_blank"><b>Studio Stein</b></a></p>
				
			</div>
		</div>
		
		<script>
			feather.replace()
		</script>
		
	</body>
	
</html>