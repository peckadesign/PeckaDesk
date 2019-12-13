<?php declare(strict_types = 1);

require __DIR__ . '/../vendor/autoload.php';

$configurator = \PeckaDesk\Bootstrap::boot();
$configurator
	->createContainer()
	->getByType(\Nette\Application\Application::class)
	->run()
;
