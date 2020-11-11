<?php

	$dirFiles = scandir('../../');
	$htmlFiles = [];
	foreach ($dirFiles as $x => $xval) {
		if (strpos($xval, '.html') !== false) {
			$htmlFiles[] = $xval;
		}
	}
	
	foreach ($htmlFiles as $x => $xval) {
		// Read file
			$file = fopen('../../'.$xval, "r") or die("Unable to open file!");
			$content = fread($file, filesize('../../'.$xval));
			fclose($file);
			
		// Change content
			$content = "<?php include 'admin/user/init.php'; ?>" . $content;
			foreach($htmlFiles as $y => $yval) {
				$newName = str_replace(".html",".php",$yval);
				$content = str_replace($yval,$newName,$content);
			}
			
		// Write File
			$file = fopen('../../'.$xval, "w") or die("Unable to open file!");
			fwrite($file, $content);
			fclose($file);
		
		// Rename File
			rename('../../'.$xval, '../../'.str_replace(".html",".php",$xval));
	}
	
	header('LOCATION:../index.php'); die();

?>