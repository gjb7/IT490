<?php
	require_once 'common.php';
	
	use Illuminate\Support\Facades\Facade;
	
	$app = new IT490\Application();
	Facade::setFacadeApplication($app);
	
	$app->root = __DIR__ . '/app';
	$app->boot();
	
	$app->run();
?>