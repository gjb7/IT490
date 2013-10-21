<?php
	require_once 'vendor/autoload.php';
	
	$app = new IT490\Application();
	$app->boot();
	
	$app->router()->serve();
?>