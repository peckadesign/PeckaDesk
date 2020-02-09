<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Projects\Grids;

final class Factory
{

	private \PeckaDesk\Dashboard\Grids\BaseFactory $baseFactory;

	private \PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade;

	private \Nette\Security\User $user;


	public function __construct(
		\PeckaDesk\Dashboard\Grids\BaseFactory $baseFactory,
		\PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade,
		\Nette\Security\User $user
	)
	{
		$this->baseFactory = $baseFactory;
		$this->projectFacade = $projectFacade;
		$this->user = $user;
	}


	public function create(): \Ublaboo\DataGrid\DataGrid
	{
		$dataGrid = $this->baseFactory->create();

		$source = new \Ublaboo\DataGrid\DataSource\DoctrineDataSource($this->projectFacade->queryFactory(), 'id');
		$dataGrid->setDataSource($source);

		$dataGrid->addColumnText('name', 'name');

		if ($this->user->isAllowed(\PeckaDesk\Dashboard\Users\AclFactory::RESOURCE_PROJECTS, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_ADD)) {
			$this->baseFactory->createAddButton($dataGrid, ':Dashboard:Projects:Add:');
		}

		$this->baseFactory->createDetailButton($dataGrid, ':Dashboard:Projects:Detail:', function (\PeckaDesk\Model\Projects\Project $project): bool {
			return $this->user->isAllowed($project, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_READ);
		});

		$this->baseFactory->createEditButton($dataGrid, ':Dashboard:Projects:Edit:', function (\PeckaDesk\Model\Projects\Project $project): bool {
			return $this->user->isAllowed($project, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_EDIT);
		});

		return $dataGrid;
	}

}
