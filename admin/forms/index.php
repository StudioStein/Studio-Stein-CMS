<?php if (!isset($_SESSION)) {session_start();} if (!isset($_SESSION['login'])) {header('LOCATION:../login.php'); die();} 
	
	// User Permission
	if ($_SESSION["user-type"]["analytics"] == 0) {header('LOCATION:../login.php'); die();}
	// ---------------
	
	$file = fopen("formsubmissions.json", "r") or die("Unable to open file!");
	$json = fread($file,filesize("formsubmissions.json"));
	fclose($file);
	$obj = json_decode($json);
	
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
				
				<p class="breadcrumbs"><b><a href="../index.php">Dashboard</a> <i data-feather="chevron-right"></i> Formulários</p>
				
				<h2><i data-feather="file"></i> Formulários</h2>
				
				<div style="overflow-x:auto;">
					<table>
						<tr>
							<td><b>Horário</b></td>
							<td><b>Formulário</b></td>
							<td><b>Ações</b></td>
						</tr>
						
						<?php
								for($x = count($obj)-1; $x >= 0; $x--) {
								echo "<tr>";
								echo "<td>".date("d.m.Y - H:i:s", $obj[$x]->time)."</td>";
								echo "<td>".$obj[$x]->submit."</td>";
								echo "<td><b><a href='formread.php?id=". $x ."'><i data-feather='file-text'></i> Ler</a></b></td>";
								echo "</tr>";
							}
						
						?>
					</table>
				</div>
				
				<p class="footer">dev by <a href="http://studiostein.com.br/" target="_blank"><b>Studio Stein</b></a></p>
			  
			</div>
		</div>
		
		
		
		<script>
			feather.replace()
		</script>

		
	</body>
	
</html>