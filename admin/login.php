<?php
	if (!isset($_SESSION)) {session_start();}
    if(isset($_SESSION['login'])) {
        header('LOCATION:dashboard.php'); die();
    }
?>
<html>
	<head>
	
		<title>Login - Studio Stein</title>
		
	</head>
	
	<body>
	
		<?php
			// define variables and set to empty values
			$user = $pass = $error = "";

			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				if (empty($_POST["user"]) or empty($_POST["pass"])) {
					$error = "Preencha todos os campos";
				} else {
					$user = test_input($_POST["user"]); // Clean name input
					$pass = test_input($_POST["pass"]); // Clean pass input
					
					$_SESSION['request-accounts'] = true;
					include 'accounts.php';
					
					if (!isset($accounts[$user])) {
						$error = "Usuário ou Senha invalidos";
					} else {
						if (md5($pass) == $accounts[$user]["password"]) {
							$_SESSION["login"] = true;
							$_SESSION["user-nome"] = $accounts["$user"]["nome"];
							$_SESSION["user-type"] = $accounts["$user"]["type"];
							
							header('LOCATION:dashboard.php'); die();
						} else {
							$error = "Usuário ou Senha invalidos";
						}
					}
				}
			}
			  
			function test_input($data) {
			  $data = trim($data);
			  $data = stripslashes($data);
			  $data = htmlspecialchars($data);
			  return $data;
			}
		?>
	
	
		<h1>Login</h1>
		
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<p>Usuário</p>
			<input type="text" placeholder="Usuário" name="user" value="<?php echo $user; ?>">
			
			<p>Senha</p>
			<input type="password" placeholder="Senha" name="pass" value="<?php echo $pass; ?>">
			
			<input type="submit" name="submit" value="Login">
			
			<p class="error"><?php echo $error; ?></p>
			
		</form>
		
	</body>
	
</html>