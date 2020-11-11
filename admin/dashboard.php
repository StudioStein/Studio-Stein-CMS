<?php 

session_start();

$pageInfo = ["name"=>"Dashboard"];

include "admin/class_master_admin.php";
include "admin/class_analytics_admin.php";
include "admin/class_forms_admin.php";

check_logout();

include "ui/ui-header.php"; 

$analytics = new adminAnalytics();
$form = new adminForms();

?>
		
		<div class="content">
			
			<div class="space large"></div>
			
			<h1>Dashboard</h1>
			
			<div class="divider"></div>
			
			<div class="row">
				
				<div class="col-3">
					<div class="card">
						<div className="card-container">
							<div class="bg-blue-600 p-4">
								<span class="icon subtitle u-center text-blue-100" style="font-size: 28px">
									<i class="far fa-wrapper fa-eye"></i>
								</span>
							</div>
						</div>
						<div class="content u-text-center">
							<p id="projectname" class="title mt-2 mb-0">Acessos</p>
							<p><?php echo $analytics->get_total()->acessos; ?></p>
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="card">
						<div className="card-container">
							<div class="bg-blue-600 p-4">
								<span class="icon subtitle u-center text-blue-100" style="font-size: 28px">
									<i class="far fa-wrapper fa-user"></i>
								</span>
							</div>
						</div>
						<div class="content u-text-center">
							<p id="projectname" class="title mt-2 mb-0">Usuários</p>
							<p><?php echo $analytics->get_total()->users; ?></p>
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="card">
						<div className="card-container">
							<div class="bg-blue-600 p-4">
								<span class="icon subtitle u-center text-blue-100" style="font-size: 28px">
									<i class="far fa-wrapper fa-address-card"></i>
								</span>
							</div>
						</div>
						<div class="content u-text-center">
							<p id="projectname" class="title mt-2 mb-0">Com Dados</p>
							<p><?php if (!$form->get_user_list()==false) { echo count($form->get_user_list()); } else { echo "0"; } ?></p>
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="card">
						<div className="card-container">
							<div class="bg-blue-600 p-4">
								<span class="icon subtitle u-center text-blue-100" style="font-size: 28px">
									<i class="far fa-wrapper fa-edit"></i>
								</span>
							</div>
						</div>
						<div class="content u-text-center">
							<p id="projectname" class="title mt-2 mb-0">Formulários</p>
							<p><?php echo $form->get_total()->total; ?></p>
						</div>
					</div>
				</div>
			</div>
			
			<div class="space large"></div>
			
		</div>
		
<?php include "ui/ui-footer.php"; ?>