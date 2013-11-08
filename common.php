<?php
	require_once 'vendor/autoload.php';
	
	use Illuminate\Database\Capsule\Manager as Capsule;
	use Illuminate\Events\Dispatcher;
	use Illuminate\Container\Container;
	
	if (!file_exists('app/database.php')) {
		die("ERROR: No database info provided.\n");
	}
	
	// Boot Eloquent
	$capsule = new Capsule;
	$capsule->addConnection(require_once('app/database.php'));
	$capsule->setEventDispatcher(new Dispatcher(new Container));
	$capsule->setAsGlobal();
	$capsule->bootEloquent();
?>