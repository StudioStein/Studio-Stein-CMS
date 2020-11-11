<?php
	
	date_default_timezone_set("America/Sao_Paulo");
	
	// Inclui as classes
	include 'class_analytics.php';
	include 'class_form.php';
	
	// Analytics
	$analytics = new userAnalytics();
	$form = new userForms();
	
?>