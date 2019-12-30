<?php declare(strict_types = 1);

namespace PeckaDesk\Router;

final class RouterFactory
{

	private \PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade;

	/**
	 * @var \PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface
	 */
	private \PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade;


	public function __construct(
		\PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade,
		\PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade
	)
	{
		$this->issueFacade = $issueFacade;
		$this->projectFacade = $projectFacade;
	}


	public function createRouter(): \Nette\Routing\RouteList
	{
		$router = new \Nette\Routing\RouteList();

		$router->addRoute('dashboard/projects/<projectId [0-9]+>/issue', [
			'presenter' => 'Dashboard:Issues:Add',
			'action' => 'default',
			NULL => [
				\Nette\Routing\Route::FILTER_OUT => static function (array $params) {
					if ( ! isset($params['project'])) {
						return NULL;
					}

					$params['projectId'] = $params['project']->getId();
					unset($params['project']);

					return $params;
				},
				\Nette\Routing\Route::FILTER_IN => function (array $params) {
					$params['project'] = $this->projectFacade->getById((int) $params['projectId']);
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
				\Nette\Routing\Route::FILTER_IN => function (array $params) {
					$params['issue'] = $this->issueFacade->getById((int) $params['id']);
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
				\Nette\Routing\Route::FILTER_IN => function (array $params) {
					$params['issue'] = $this->issueFacade->getById((int) $params['id']);
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
				\Nette\Routing\Route::FILTER_OUT => static function (array $params) {
					if ( ! isset($params['project'])) {
						return NULL;
					}

					$params['id'] = $params['project']->getId();
					unset($params['project']);

					return $params;
				},
				\Nette\Routing\Route::FILTER_IN => function (array $params) {
					$params['project'] = $this->projectFacade->getById((int) $params['id']);
					unset($params['id']);

					return $params;
				},
			],
		]);

		$router->addRoute('dashboard/projects/<id [0-9]+>[/<action>]', [
			'presenter' => 'Dashboard:Projects:Detail',
			'action' => 'default',
			NULL => [
				\Nette\Routing\Route::FILTER_OUT => static function (array $params) {
					if ( ! isset($params['project'])) {
						return NULL;
					}

					$params['id'] = $params['project']->getId();
					unset($params['project']);

					return $params;
				},
				\Nette\Routing\Route::FILTER_IN => function (array $params) {
					$params['project'] = $this->projectFacade->getById((int) $params['id']);
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

		$router->addRoute('/', [
			'presenter' => 'Dashboard:Projects:List',
			'action' => 'default',
		]);

		return $router;
	}
}
