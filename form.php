<?php include 'admin/user/init.php'; ?>

<html>
	<head>
	
		<title>Studio Stein</title>
		
	</head>
	
	<body>
	
		<h1>Form</h1>
		
		
		<form method="post" action="form.php">  
			<input type="hidden" name="form" value="Teste">
			Name: <input type="text" name="name" value="Matheus Stein">
			<br><br>
			
			Fone: <input type="text" name="fone" value="4999202.2430">
			<br><br>
			
			<input type="submit" value="submit" id="submit">
		</form>
		
		<script>
			document.getElementById('submit').click();
		</script>
		
	</body>
	
</html>