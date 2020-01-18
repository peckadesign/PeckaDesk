<?php declare(strict_types = 1);

namespace PeckaDesk\Router;

final class RouterFactory
{

	private \PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade;

	private \PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade;

	private \PeckaDesk\Dashboard\Files\Model\FileFacadeInterface $fileFacade;

	private \PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade;


	public function __construct(
		\PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade,
		\PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade,
		\PeckaDesk\Dashboard\Files\Model\FileFacadeInterface $fileFacade,
		\PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade
	)
	{
		$this->issueFacade = $issueFacade;
		$this->projectFacade = $projectFacade;
		$this->fileFacade = $fileFacade;
		$this->userFacade = $userFacade;
	}


	public function createRouter(): \Nette\Routing\RouteList
	{
		$router = new \Nette\Routing\RouteList();

		$router->addRoute('dashboard/projects/<projectId [0-9]+>/issue', [
			'presenter' => 'Dashboard:Issues:Add',
			'action' => 'default',
			NULL => [
				\Nette\Routing\Route::FILTER_OUT => static function (array $params): ?array {
					if ( ! isset($params['project'])) {
						return NULL;
					}

					$params['projectId'] = $params['project']->getId();
					unset($params['project']);

					return $params;
				},
				\Nette\Routing\Route::FILTER_IN => function (array $params): ?array {
					try {
						$params['project'] = $this->projectFacade->getById((int) $params['projectId']);
					} catch (\PeckaDesk\Dashboard\Model\EntityNotFoundException $e) {
						return NULL;
					}
					unset($params['projectId']);

					return $params;
				},
			],
		]);

		$router->addRoute('dashboard/projects/<projectId [0-9]+>/issue/<id [0-9]+>', [
			'presenter' => 'Dashboard:Issues:Detail',
			'action' => 'default',
			NULL => [
				\Nette\Routing\Route::FILTER_OUT => static function (array $params): ?array {
					if ( ! isset($params['issue'])) {
						return NULL;
					}

					$params['projectId'] = $params['issue']->getProject()->getId();
					$params['id'] = $params['issue']->getId();
					unset($params['issue']);

					return $params;
				},
				\Nette\Routing\Route::FILTER_IN => function (array $params): ?array {
					try {
						$params['issue'] = $this->issueFacade->getById((int) $params['id']);
					} catch (\PeckaDesk\Dashboard\Model\EntityNotFoundException $e) {
						return NULL;
					}
					unset($params['projectId']);
					unset($params['id']);

					return $params;
				},
			],
		]);

		$router->addRoute('dashboard/projects/<projectId [0-9]+>/issue/<id [0-9]+>/edit', [
			'presenter' => 'Dashboard:Issues:Edit',
			'action' => 'default',
			NULL => [
				\Nette\Routing\Route::FILTER_OUT => static function (array $params): ?array {
					if ( ! isset($params['issue'])) {
						return NULL;
					}

					$params['projectId'] = $params['issue']->getProject()->getId();
					$params['id'] = $params['issue']->getId();
					unset($params['issue']);

					return $params;
				},
				\Nette\Routing\Route::FILTER_IN => function (array $params): ?array {
					try {
						$params['issue'] = $this->issueFacade->getById((int) $params['id']);
					} catch (\PeckaDesk\Dashboard\Model\EntityNotFoundException $e) {
						return NULL;
					}
					unset($params['projectId']);
					unset($params['id']);

					return $params;
				},
			],
		]);

		$router->addRoute('dashboard/projects/<id [0-9]+>/edit', [
			'presenter' => 'Dashboard:Projects:Edit',
			'action' => 'default',
			NULL => [
				\Nette\Routing\Route::FILTER_OUT => static function (array $params): ?array {
					if ( ! isset($params['project'])) {
						return NULL;
					}

					$params['id'] = $params['project']->getId();
					unset($params['project']);

					return $params;
				},
				\Nette\Routing\Route::FILTER_IN => function (array $params): ?array {
					try {
						$params['project'] = $this->projectFacade->getById((int) $params['id']);
					} catch (\PeckaDesk\Dashboard\Model\EntityNotFoundException $e) {
						return NULL;
					}
					unset($params['id']);

					return $params;
				},
			],
		]);

		$router->addRoute('dashboard/projects/<id [0-9]+>[/<action>]', [
			'presenter' => 'Dashboard:Projects:Detail',
			'action' => 'default',
			NULL => [
				\Nette\Routing\Route::FILTER_OUT => static function (array $params): ?array {
					if ( ! isset($params['project'])) {
						return NULL;
					}

					$params['id'] = $params['project']->getId();
					unset($params['project']);

					return $params;
				},
				\Nette\Routing\Route::FILTER_IN => function (array $params): ?array {
					try {
						$params['project'] = $this->projectFacade->getById((int) $params['id']);
					} catch (\PeckaDesk\Dashboard\Model\EntityNotFoundException $e) {
						return NULL;
					}
					unset($params['id']);

					return $params;
				},
			],
		]);

		$router->addRoute('dashboard/files/<id [0-9]+>', [
			'presenter' => 'Dashboard:File',
			'action' => 'default',
			NULL => [
				\Nette\Routing\Route::FILTER_OUT => static function (array $params): ?array {
					if ( ! isset($params['file'])) {
						return NULL;
					}

					$params['id'] = $params['file']->getId();
					unset($params['file']);

					return $params;
				},
				\Nette\Routing\Route::FILTER_IN => function (array $params): ?array {
					try {
						$params['file'] = $this->fileFacade->getById((int) $params['id']);
					} catch (\PeckaDesk\Dashboard\Model\EntityNotFoundException $e) {
						return NULL;
					}
					unset($params['id']);

					return $params;
				},
			],
		]);

		$router->addRoute('dashboard/projects/add', [
			'presenter' => 'Dashboard:Projects:Add',
			'action' => 'default',
		]);

		$router->addRoute('dashboard/login', [
			'presenter' => 'Dashboard:Login',
			'action' => 'default',
		]);

		$router->addRoute('dashboard/peckanotes/oauth2/authorize', [
			'presenter' => 'Dashboard:PeckaNotesLogin:Login:OAuth2',
			'action' => 'authorize',
		]);

		$router->addRoute('dashboard/users', [
			'presenter' => 'Dashboard:Users:List',
			'action' => 'default',
		]);

		$router->addRoute('dashboard/users/add', [
			'presenter' => 'Dashboard:Users:Add',
			'action' => 'default',
		]);

		$router->addRoute('dashboard/users/<id [0-9]+>', [
			'presenter' => 'Dashboard:Users:Detail',
			'action' => 'default',
			NULL => [
				\Nette\Routing\Route::FILTER_OUT => static function (array $params): ?array {
					if ( ! isset($params['user'])) {
						return NULL;
					}

					$params['id'] = $params['user']->getId();
					unset($params['user']);

					return $params;
				},
				\Nette\Routing\Route::FILTER_IN => function (array $params): ?array {
					try {
						$params['user'] = $this->userFacade->getById((int) $params['id']);
					} catch (\PeckaDesk\Dashboard\Model\EntityNotFoundException $e) {
						return NULL;
					}
					unset($params['id']);

					return $params;
				},
			],
		]);

		$router->addRoute('dashboard/users/<id [0-9]+>/edit', [
			'presenter' => 'Dashboard:Users:Edit',
			'action' => 'default',
			NULL => [
				\Nette\Routing\Route::FILTER_OUT => static function (array $params): ?array {
					if ( ! isset($params['user'])) {
						return NULL;
					}

					$params['id'] = $params['user']->getId();
					unset($params['user']);

					return $params;
				},
				\Nette\Routing\Route::FILTER_IN => function (array $params): ?array {
					try {
						$params['user'] = $this->userFacade->getById((int) $params['id']);
					} catch (\PeckaDesk\Dashboard\Model\EntityNotFoundException $e) {
						return NULL;
					}
					unset($params['id']);

					return $params;
				},
			],
		]);

		$router->addRoute('/', [
			'presenter' => 'Dashboard:Projects:List',
			'action' => 'default',
		]);

		return $router;
	}
}
