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
		
	</head>
	
	<body>

	
		<h1>Dashboard</h1>
		<p>Bem vindo(a), <?php echo $_SESSION['user-nome']; ?>!</p>
		
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<input type='submit' name="logout" value="Logout">
		</form>
		
	</body>
	
</html>