<?php declare(strict_types = 1);

namespace PeckaDesk;

final class Bootstrap
{

	public static function boot(): \Nette\Configurator
	{
		$configurator = new \Nette\Configurator();

		$configurator->setDebugMode(TRUE);
		$configurator->enableTracy(__DIR__ . '/../log');

		$configurator->setTimeZone('Europe/Prague');
		$configurator->setTempDirectory(__DIR__ . '/../temp');

		$configurator
			->addConfig(__DIR__ . '/config/common.neon')
			->addConfig(__DIR__ . '/config/local.neon')
		;

		return $configurator;
	}

}
