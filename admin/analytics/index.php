<?php if (!isset($_SESSION)) {session_start();} if (!isset($_SESSION['login'])) {header('LOCATION:../login.php'); die();} 
	
	// User Permission
	if ($_SESSION["user-type"]["analytics"] == 0) {header('LOCATION:../login.php'); die();}
	// ---------------
	
	$file = fopen("stats.json", "r") or die("Unable to open file!");
	$json = fread($file,filesize("stats.json"));
	fclose($file);
	$obj = json_decode($json);
	
	date_default_timezone_set("America/Sao_Paulo");
?>

<html>
	<head>
	
		<title>Estatísticas - Studio Stein</title>
		
	</head>
	
	<body>
	
		<h1>Estatísticas</h1>
		
		<h3>Total de Acessos</h3>
		<p><?php echo number_format(count($obj->data), 0, ',', ' '); ?> Visualizações.</p>
		
		<h3>Total de Usuários</h3>
		<p><?php echo number_format($obj->userid, 0, ',', ' '); ?> Usuários.</p>
		
		<h3>Usuários que retornam</h3>
		<p><?php 
			
			$user = array();
			$return = 0;
			
			// Add an array for every user with a subarray for every section
			for($x = count($obj->data); $x > 0; $x--) {
				$user[$obj->data[$x-1][1]][$obj->data[$x-1][2]] = 1;
			}
			
			// For every user with more than one section, add one return
			for($x = count($user); $x > 0; $x--) {
				if (count($user[$x]) > 1) {
					$return += 1;
				}
			}
				
			$userReturns = ($return*100)/count($user);
			
			echo number_format($userReturns, 2, ',', ' '); 
			
		?>% de retorno dos usuários.</p>
		
		<h3>Dispositivos</h3>
		<p><?php 
			
			$device = [0,0,0,0,0,0,0];
			
			for($x = count($obj->data); $x > 0; $x--) {
				if ($obj->data[$x-1][4] == "Mobile - iOS") 		{ $device[0]+=1; } else
				if ($obj->data[$x-1][4] == "Mobile - Android") 	{ $device[1]+=1; } else
				if ($obj->data[$x-1][4] == "Mobile - Outro") 	{ $device[2]+=1; } else
				if ($obj->data[$x-1][4] == "Tablet - iOS") 		{ $device[3]+=1; } else
				if ($obj->data[$x-1][4] == "Tablet - Android") 	{ $device[4]+=1; } else
				if ($obj->data[$x-1][4] == "Tablet - Outro") 	{ $device[5]+=1; } else
				if ($obj->data[$x-1][4] == "Desktop") 			{ $device[6]+=1; }
			}
			
			$sum = $device[0]+$device[1]+$device[2];
			$percent = ($sum*100)/count($obj->data);
			echo "<b>Mobile: ".number_format($percent, 2, ',', ' ')."% (".number_format($sum, 0, ',', ' ').")</b><br>"; 
			
				$sum = $device[0];
				$percent = ($sum*100)/count($obj->data);
				echo "Mobile - iOS: ".number_format($percent, 2, ',', ' ')."% (".number_format($sum, 0, ',', ' ').")<br>"; 
				
				$sum = $device[1];
				$percent = ($sum*100)/count($obj->data);
				echo "Mobile - Android: ".number_format($percent, 2, ',', ' ')."% (".number_format($sum, 0, ',', ' ').")<br>"; 
				
				$sum = $device[2];
				$percent = ($sum*100)/count($obj->data);
				echo "Mobile - Outro: ".number_format($percent, 2, ',', ' ')."% (".number_format($sum, 0, ',', ' ').")<br><br>"; 
				
			$sum = $device[3]+$device[4]+$device[5];
			$percent = ($sum*100)/count($obj->data);
			echo "<b>Tablet: ".number_format($percent, 2, ',', ' ')."% (".number_format($sum, 0, ',', ' ').")</b><br>"; 
			
				$sum = $device[3];
				$percent = ($sum*100)/count($obj->data);
				echo "Tablet - iOS: ".number_format($percent, 2, ',', ' ')."% (".number_format($sum, 0, ',', ' ').")<br>"; 
				
				$sum = $device[4];
				$percent = ($sum*100)/count($obj->data);
				echo "Tablet - Android: ".number_format($percent, 2, ',', ' ')."% (".number_format($sum, 0, ',', ' ').")<br>"; 
				
				$sum = $device[5];
				$percent = ($sum*100)/count($obj->data);
				echo "Tablet - Outro: ".number_format($percent, 2, ',', ' ')."% (".number_format($sum, 0, ',', ' ').")<br><br>"; 
				
			$sum = $device[6];
			$percent = ($sum*100)/count($obj->data);
			echo "<b>Desktop: ".number_format($percent, 2, ',', ' ')."% (".number_format($sum, 0, ',', ' ').")</b><br>"; 
			
		?></p>
		
		<h3>Acessos</h3>
		
		<style>
			table, th, td {
			  border: 1px solid black;
			  border-collapse: collapse;
			}
			
			td { padding: 8px 12px; }
		</style>
		
		<table>
			<tr>
				<td><b>Horário</b></td>
				<td><b>Usuário</b></td>
				<td><b>Sessão</b></td>
				<td><b>Página</b></td>
				<td><b>Dispositivo</b></td>
				<td><b>IP</b></td>
			</tr>
			
			<?php
					for($x = count($obj->data); $x > 0; $x--) {
					echo "<tr>";
					echo "<td>".date("d.m.Y - H:i:s", $obj->data[$x-1][0])."</td>";
					echo "<td><a href='user.php?user=".$obj->data[$x-1][1]."'>User ".$obj->data[$x-1][1]."</a></td>";
					echo "<td>".$obj->data[$x-1][2]."</td>";
					echo "<td>".$obj->data[$x-1][3]."</td>";
					echo "<td>".$obj->data[$x-1][4]."</td>";
					echo "<td>".$obj->data[$x-1][5]."</td>";
					echo "</tr>";
				}
			
			?>
		</table>
		
	</body>
	
</html>