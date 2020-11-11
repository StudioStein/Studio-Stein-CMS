<?php 

session_start();

$pageInfo = ["name"=>"User"];

include "admin/class_master_admin.php";
include "admin/class_analytics_admin.php";
include "admin/class_forms_admin.php";

user_permission("analytics");
check_logout();

include "ui/ui-header.php"; 

$analytics = new adminAnalytics();
$form = new adminForms();

$total = $analytics->get_total();

if (isset($_GET["user"])) {
	if ($_GET['user'] <= $total->users) {
		$user = $_GET['user'];
	} else {
		$user = $total->users;
	}
} else {
	$user = $total->users;
}

$userData = $form->get_user_data($user);
$userAccess = $analytics->get_user_data($user);

?>
		
		<div class="content">
			
			<div class="space large"></div>
			
			<h1>Usuário <?php echo $user; ?></h1>
			
			<div class="divider"></div>
			
			<h3>Dados</h3>
			
			<div class="row">
			<?php
			
			if ($userData == false) { echo "<p>Usuário não tem dados ainda.</p>"; }
			else {
				for ($x = 0; $x < count($userData); $x++) {					
					echo '<div class="col-3"><div class="card bg-white p-4 "><div className="content">';
					
					echo '<div class="u-text-center"><strong>Formulário</strong><br>'.$userData[$x]->form.'</div>';
					echo '<div class="u-text-center"><strong>Data</strong><br>'.date("d.m.Y - H:i:s", $userData[$x]->time).'</div>';
					
					if (isset($userData[$x]->name)) { echo '<div class="u-text-center"><strong>Nome</strong><br>'.$userData[$x]->name.'</div>'; }
					if (isset($userData[$x]->fone)) { echo '<div class="u-text-center"><strong>Telefone</strong><br>'.$userData[$x]->fone.'</div>'; }
					if (isset($userData[$x]->phone)) { echo '<div class="u-text-center"><strong>Telefone</strong><br>'.$userData[$x]->phone.'</div>'; }
					if (isset($userData[$x]->email)) { echo '<div class="u-text-center"><strong>Email</strong><br>'.$userData[$x]->email.'</div>'; }
					
					echo '</div></div></div>';
				}
				
			}
			
			?>
			</div>
			
			<div class="divider"></div>
			
			<h3>Acessos</h3>
			
			<?php
			
			$dispositivo = $ip = "";
				
				for($x = count($userAccess); $x > 0; $x--) {
					echo '<div class="card bg-white p-4"><div className="content">';
					echo "<div class='title'>Sessão ".($x)."</div>";
					echo "<p>Usuário entrou no site.</p>";
					
					echo "<table class='table'><thead><tr><th>Horário</th><th>Página</th></tr></thead><tbody>";
					
					for($y = count($userAccess[$x])-1; $y >= 0; $y--) {
						echo "<tr><td>".date("d.m.Y - H:i:s", $userAccess[$x][$y][0])."</td><td>".$userAccess[$x][$y][3]."</td></tr>";
						$dispositivo = $userAccess[$x][$y][4];
						$ip = $userAccess[$x][$y][5];	
					}
					
					$details = json_decode(file_get_contents("http://ipinfo.io/".$ip."/json"));
					
					echo "</tbody></table>";
					echo "<p><strong>Dispositivo:</strong> ".$dispositivo."</p>";
					if (isset($details->city)) { echo "<p><strong>Localização:</strong> ".$details->city.", ".$details->region.", ".$details->country."</p>"; }
					echo "<p>Usuário saiu do site.</p></div></div>";
					
				}
				
			
			?>
			
			
			
			<div class="space large"></div>
			
		</div>
		
<?php include "ui/ui-footer.php"; ?>