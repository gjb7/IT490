<?php
	$action = 'migrate';
	
	if ($argc >= 2) {
		$action = $argv[1];
	}
	
	require_once 'common.php';
	
	use Illuminate\Database\ConnectionResolver;
	use Illuminate\Database\Migrations\Migrator;
	use Illuminate\Database\Migrations\DatabaseMigrationRepository;
	use Illuminate\Database\Migrations\MigrationCreator;
	use Illuminate\Filesystem\Filesystem;
	use Illuminate\Database\Eloquent\Model as Eloquent;
	
	$filesystem = new Filesystem;
	$resolver = Eloquent::getConnectionResolver();
	$repository = new DatabaseMigrationRepository($resolver, 'migrations');
	
	$path = __DIR__ . '/app/migration';
	
	if ($action == 'migrate') {
		$migrator = new Migrator($repository, $resolver, $filesystem);
		
		if (!$repository->repositoryExists()) {
			$repository->createRepository();
		}
		
		$migrator->run($path);
	}
	else if ($action == 'new') {
		if ($argc >= 3) {
			$name = $argv[2];
		}
		else {
			die("Usage: " . $argv[0] . " new <name>\n");
		}
		
		$creator = new MigrationCreator($filesystem);
		$createdPath = $creator->create($name, $path);
		
		echo "Migration created at '" . $createdPath . "'.\n";
	}
?>