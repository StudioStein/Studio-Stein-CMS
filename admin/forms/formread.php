<?php if (!isset($_SESSION)) {session_start();} if (!isset($_SESSION['login'])) {header('LOCATION:../login.php'); die();} 
	
	// User Permission
	if ($_SESSION["user-type"]["analytics"] == 0) {header('LOCATION:../login.php'); die();}
	// ---------------
	
	if (!isset($_GET["id"])) { die("No parameter or wrong parameter is used! Go back."); }
	
	$file = fopen("formsubmissions.json", "r") or die("Unable to open file!");
	$json = fread($file,filesize("formsubmissions.json"));
	fclose($file);
	$obj = json_decode($json);
	
	$form = $obj[number_format($_GET['id'])];
	
	date_default_timezone_set("America/Sao_Paulo");
?>

<html>
	<head>
	
		<title>Formulários - Studio Stein</title>
		
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
				
				<p class="breadcrumbs"><b><a href="../index.php">Dashboard</a> <i data-feather="chevron-right"></i> <a href="index.php">Formulários</a> <i data-feather="chevron-right"></i> Formulário</p>
				
				<h2><i data-feather="file"></i> Formulário <?php echo $_GET['id']; ?></h2>
				
				<?php
				
					foreach($form as $x => $xval) {						
						if ($x == "time") { echo "<h3>Horário</h3>"; echo "<p>" . date("d.m.Y - H:i:s", $xval) . "</p>"; }
						else if ($x == "submit") { echo "<h3>Formulário</h3>"; echo "<p>" . $xval . "</p>"; }
						else {	
							echo "<h3>" . $x . "</h3>";
							echo "<p>" . $xval . "</p>";
						}
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