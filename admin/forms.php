<?php 

session_start();

$pageInfo = ["name"=>"Formulários"];

include "admin/class_master_admin.php";
include "admin/class_analytics_admin.php";
include "admin/class_forms_admin.php";

user_permission("forms");
check_logout();

include "ui/ui-header.php"; 

$analytics = new adminAnalytics();
$form = new adminForms();

$total = $form->get_total();

if (isset($_GET["p"])) {
	if ($_GET['p'] <= ceil($total->total/1000)) {
		$data = $form->get_page($_GET["p"]);
		$page = $_GET['p'];
	} else {
		$data = $form->get_page(0);
		$page = ceil($total->total/1000);
	}
} else {
	$data = $form->get_page(0);
	$page = ceil($total->total/1000);
}


?>
		
		<div class="content">
			
			<div class="space large"></div>
			
			<h1>Formulários</h1>
			
			<div class="divider"></div>
			
			<div style="overflow-x:auto;">
				<table class="table small">
				
					<thead>
						<tr>
							<th>Horário</th>
							<th>Formulário</th>
							<th>Usuário</th>
							<th>Nome</th>
							<th>Sessão</th>
						</tr>
					</thead>
					
					<tbody>
						<?php 
							$formNumb = ($page-1)*1000;
							for ($x = count($data->submits)-1; $x >= 0; $x--) {
								echo "<tr>";
								echo "<td><a href='form.php?form=".($formNumb+$x+1)."'>" . date("d.m.Y - H:i:s", $data->submits[$x]->time) . "</a></td>";
								echo "<td><a href='form.php?form=".($formNumb+$x+1)."'>".$data->submits[$x]->form."</a></td>";
								echo "<td><a href='form.php?form=".($formNumb+$x+1)."'>User ".$data->submits[$x]->user."</a></td>";
								echo "<td><a href='form.php?form=".($formNumb+$x+1)."'>".$form->get_user_single_data($data->submits[$x]->user,"name")."</a></td>";
								echo "<td><a href='form.php?form=".($formNumb+$x+1)."'>".$data->submits[$x]->section."</a></td>";
								echo "</tr>";
							}
						
						?>
					</tbody>
				
				</table>
			</div>
			
			<div class="pagination pagination-bordered">
				<?php
				
					for ($x = ceil($total->total/1000); $x > 0; $x--) {
						if ($x == $page) { echo '<div class="pagination-item short selected"><a href="?p='.$x.'">'.$x.'</a></div>'; }
						else { echo '<div class="pagination-item short"><a href="?p='.$x.'">'.$x.'</a></div>'; }
					}
				
				?>			
			</div>
			
			<div class="space large"></div>
			
		</div>
		
<?php include "ui/ui-footer.php"; ?>