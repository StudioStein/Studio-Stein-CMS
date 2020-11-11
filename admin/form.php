<?php 

session_start();

$pageInfo = ["name"=>"Formulário"];

include "admin/class_master_admin.php";
include "admin/class_analytics_admin.php";
include "admin/class_forms_admin.php";

user_permission("forms");
check_logout();

include "ui/ui-header.php"; 

$analytics = new adminAnalytics();
$form = new adminForms();

$total = $form->get_total();

if (isset($_GET["form"])) {
	if ($_GET['form'] <= $total->total) {
		$formN = $_GET['form'];
	} else {
		$formN = $total->total;
	}
} else {
	$formN = $total->total;
}

$formData = $form->get_form($formN);

?>
		
		<div class="content">
			
			<div class="space large"></div>
			
			<h1>Formulário <?php echo $formN; ?></h1>
			
			<div class="divider"></div>
			
			<h3><?php echo $formData->form; ?></h3>
			
			<?php
			
			echo "<p class='faded'>".date("d.m.Y - H:i:s", $formData->time)."</p><br>";
			if (isset($formData->name)) { echo "<p><strong>Nome: </strong>".$formData->name."</p><br>"; }
			if (isset($formData->nome)) { echo "<p><strong>Nome: </strong>".$formData->nome."</p><br>"; }
			if (isset($formData->email)) { echo "<p><strong>Email: </strong>".$formData->email."</p><br>"; }
			if (isset($formData->fone)) { echo "<p><strong>Telefone: </strong>".$formData->fone."</p><br>"; }
			if (isset($formData->phone)) { echo "<p><strong>Telefone: </strong>".$formData->phone."</p><br>"; }
			if (isset($formData->message)) { echo "<p><strong>Mensagem:</strong><br>".$formData->message."</p><br>"; }			
			if (isset($formData->interest)) { echo "<p><strong>Interesse:</strong><br>".$formData->interest."</p><br>"; }	
			
			?>
			
			<div class="divider"></div>
			
			<a href="user.php?user=<?php echo $formData->user; ?>"><button class="btn-primary">Informações do Usuário</button></a>
			
			
			<div class="space large"></div>
			
		</div>
		
<?php include "ui/ui-footer.php"; ?>