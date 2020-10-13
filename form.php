<?php include 'admin/init.php'; ?>

<html>
	<head>
	
		<title>Studio Stein</title>
		
	</head>
	
	<body>
	
		<h1>Form</h1>
		
		<?php
		
		$nameErr = $emailErr = "";
		$name = $email = $subject = $message = "";

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
		  
		  if (empty($_POST["name"])) {
			$nameErr = "Name is required";
		  } else {
			$name = test_input($_POST["name"]);
			// check if name only contains letters and whitespace
			if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
			  $nameErr = "Only letters and white space allowed";
			}
		  }
		  
		  if (empty($_POST["email"])) {
			$emailErr = "Email is required";
		  } else {
			$email = test_input($_POST["email"]);
			// check if e-mail address is well-formed
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			  $emailErr = "Invalid email format";
			}
		  }
			
		  if (empty($_POST["subject"])) {
			$subject = "";
		  } else {
			$subject = test_input($_POST["subject"]);
		  }	
			
		  if (empty($_POST["message"])) {
			$message = "";
		  } else {
			$message = test_input($_POST["message"]);
		  }
		  
		  if ($nameErr == "" && $emailErr == "") {
			  include "admin/forms/forms.php";
		  }
		  
		}

		function test_input($data) {
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
		}
		
		?>
		
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
			Name: <input type="text" name="name" value="<?php echo $name;?>">
			<span class="error">* <?php echo $nameErr;?></span>
			<br><br>
			
			E-mail: <input type="text" name="email" value="<?php echo $email;?>">
			<span class="error">* <?php echo $emailErr;?></span>
			<br><br>
			
			Assunto: <input type="text" name="subject" value="<?php echo $subject;?>">
			<br><br>
			
			Mensagem: <textarea name="message" rows="5" cols="40"><?php echo $message;?></textarea>
			<br><br>
			
			<input type="submit" name="submit" value="Contato - Email">
		</form>
		
	</body>
	
</html>