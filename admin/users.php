<?php 

session_start();

$pageInfo = ["name"=>"Users"];

include "admin/class_master_admin.php";
include "admin/class_analytics_admin.php";
include "admin/class_forms_admin.php";

user_permission("analytics");
check_logout();

include "ui/ui-header.php"; 

$analytics = new adminAnalytics();
$form = new adminForms();

$list = $form->get_user_list();


?>
		
		<div class="content">
			
			<div class="space large"></div>
			
			<h1>Usuários</h1>
			
			<div class="divider"></div>
			
			<div style="overflow-x:auto;">
			<table class="table">
			
				<thead>
					<tr>
						<th>Usuário</th>
						<th>Nome</th>
						<th>Fone</th>
						<th>Email</th>
					</tr>
				</thead>
				
				<tbody>
					<?php 
					
						for ($x = count($list)-1; $x >= 0; $x--) {
							echo "<tr>";
							echo "<td><a href='user.php?user=".$list[$x]."'>User " . $list[$x] . "</a></td>";
							echo "<td><a href='user.php?user=".$list[$x]."'>". $form->get_user_single_data($list[$x],"name") ."</a></td>";
							echo "<td><a href='user.php?user=".$list[$x]."'>". $form->get_user_single_data($list[$x],"fone") ."</a></td>";
							echo "<td><a href='user.php?user=".$list[$x]."'>". $form->get_user_single_data($list[$x],"email") ."</a></td>";
							echo "</tr>";
						}
					
					?>
				</tbody>
			
			</table>			
			</div>
			
			<div class="space large"></div>
			
		</div>
		
<?php include "ui/ui-footer.php"; ?>