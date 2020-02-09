<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Projects\Presenters;

final class ListPresenter extends \PeckaDesk\Dashboard\Presenters\BasePresenter
{

	private \PeckaDesk\Dashboard\Projects\Grids\Factory $factory;


	public function __construct(
		\PeckaDesk\Dashboard\Projects\Grids\Factory $factory
	)
	{
		parent::__construct();
		$this->factory = $factory;
	}


	public function actionDefault(): void
	{
		if ( ! $this->getUser()->isAllowed(\PeckaDesk\Dashboard\Users\AclFactory::RESOURCE_PROJECTS, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_READ)) {
			throw new \Nette\Application\ForbiddenRequestException();
		}
	}


	protected function createComponentGrid(): \Ublaboo\DataGrid\DataGrid
	{
		return $this->factory->create();
	}

}
