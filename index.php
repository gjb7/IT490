<?php
	require_once 'vendor/autoload.php';
	
	$app = IT490\Application::app();
	$app->root = __DIR__ . '/app';
	$app->boot();
	
	$app->run();
?>