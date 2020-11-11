<?php
	
	date_default_timezone_set("America/Sao_Paulo");
	
	// Inclui as classes
	include 'admin/class_master_admin.php';
	include 'admin/class_analytics_admin.php';
	include 'admin/class_forms_admin.php';
	
	// Cria as classes
	$analytics = new adminAnalytics();
	$form = new adminForms();
	
	//$a = $form->get_user_single_data(1,"name");
	$dirFiles = scandir('../');
	$htmlFiles = [];
	foreach ($dirFiles as $x => $xval) {
		if (strpos($xval, '.html') !== false) {
			$htmlFiles[] = $xval;
		}
	}
	
	foreach ($htmlFiles as $x => $xval) {
		// Read file
			$file = fopen('../'.$xval, "r") or die("Unable to open file!");
			$content = fread($file, filesize('../'.$xval));
			fclose($file);
			
		// Change content
			$content = "<?php include 'admin/user/init.php'; ?>" . $content;
			foreach($htmlFiles as $y => $yval) {
				$newName = str_replace(".html",".php",$yval);
				$content = str_replace($yval,$newName,$content);
			}
			
		// Write File
			$file = fopen('../'.$xval, "w") or die("Unable to open file!");
			fwrite($file, $content);
			fclose($file);
		
		// Rename File
			rename('../'.$xval, '../'.str_replace(".html",".php",$xval));
	}
	
	
	
	echo "done! check the chaos.";
	
?>