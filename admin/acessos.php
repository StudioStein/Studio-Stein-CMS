<?php 

session_start();

$pageInfo = ["name"=>"Acessos"];

include "admin/class_master_admin.php";
include "admin/class_analytics_admin.php";
include "admin/class_forms_admin.php";

user_permission("analytics");
check_logout();

include "ui/ui-header.php"; 

$analytics = new adminAnalytics();
$form = new adminForms();

$total = $analytics->get_total();

if (isset($_GET["p"])) {
	if ($_GET['p'] <= ceil($total->acessos/1000)) {
		$data = $analytics->get_page($_GET["p"]);
		$page = $_GET['p'];
	} else {
		$data = $analytics->get_page(0);
		$page = ceil($total->acessos/1000);
	}
} else {
	$data = $analytics->get_page(0);
	$page = ceil($total->acessos/1000);
}

?>
		
		<div class="content">
			
			<div class="space large"></div>
			
			<h1>Acessos</h1>
			
			<div class="divider"></div>
			
			<div style="overflow-x:auto;">
				<table class="table small">
				
					<thead>
						<tr>
							<th>Horário</th>
							<th>Usuário</th>
							<th>Sessão</th>
							<th>Página</th>
							<th>Dispositivo</th>
							<th>IP</th>
						</tr>
					</thead>
					
					<tbody>
						<?php 
						
							for ($x = count($data->acessos); $x > 0; $x--) {
								echo "<tr>";
								echo "<td>" . date("d.m.Y - H:i:s", $data->acessos[$x-1][0]) . "</td>";
								echo "<td><a href='user.php?user=".$data->acessos[$x-1][1]."'>User ".$data->acessos[$x-1][1]."</a></td>";
								echo "<td>".$data->acessos[$x-1][2]."</td>";
								echo "<td>".$data->acessos[$x-1][3]."</td>";
								echo "<td>".$data->acessos[$x-1][4]."</td>";
								echo "<td>".$data->acessos[$x-1][5]."</td>";
								echo "</tr>";
							}
						
						?>
					</tbody>
				
				</table>
			</div>
			
			<div class="pagination pagination-bordered">
				<?php
				
					for ($x = ceil($total->acessos/1000); $x > 0; $x--) {
						if ($x == $page) { echo '<div class="pagination-item short selected"><a href="?p='.$x.'">'.$x.'</a></div>'; }
						else { echo '<div class="pagination-item short"><a href="?p='.$x.'">'.$x.'</a></div>'; }
					}
				
				?>			
			</div>
			
			<div class="space large"></div>
			
		</div>
		
<?php include "ui/ui-footer.php"; ?>