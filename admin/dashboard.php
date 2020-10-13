<?php if (!isset($_SESSION)) {session_start();} if (!isset($_SESSION['login'])) {header('LOCATION:login.php'); die();}


    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['logout'])) {
        unset($_SESSION["login"]); 
		unset($_POST);
		header('LOCATION:login.php');
		die();
    }
	
?>
<html>
	<head>
	
		<title>Dashboard - Studio Stein</title>
		
		<link rel="stylesheet" href="ui/simple-grid.min.css">
		<link rel="stylesheet" href="ui/balloon.min.css">
		<link rel="stylesheet" href="ui/ui.css">
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
						<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
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
			 
			  <h2><i data-feather="grid"></i> Dashboard</h2>
			  
			  <p>
				<a href="analytics/index.php">
					<button><i data-feather="trending-up"></i> Estatísticas</button>
				</a>
				<a href="forms/index.php">
					<button><i data-feather="file"></i> Formulários</button>
				</a>
			  </p>
			  
			  <p class="footer">dev by <a href="http://studiostein.com.br/" target="_blank"><b>Studio Stein</b></a></p>
			  
			</div>
		</div>
		
		
		<script>
			feather.replace()
		</script>
		
	</body>
	
</html>