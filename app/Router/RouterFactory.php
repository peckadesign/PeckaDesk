<?php declare(strict_types = 1);

namespace PeckaDesk\Router;

final class RouterFactory
{

	public static function createRouter(): \Nette\Routing\RouteList
	{
		$router = new \Nette\Routing\RouteList();
		$router->addRoute('<presenter>/<action>', [
			'presenter' => 'Dashboard:Homepage',
			'action' => 'default',
		]);

		return $router;
	}
}
