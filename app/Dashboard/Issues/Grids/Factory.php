<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Grids;

final class Factory
{

	private \PeckaDesk\Dashboard\Grids\BaseFactory $baseFactory;

	private \PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade;

	private \Nette\Security\User $user;


	public function __construct(
		\PeckaDesk\Dashboard\Grids\BaseFactory $baseFactory,
		\PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade,
		\Nette\Security\User $user
	)
	{
		$this->baseFactory = $baseFactory;
		$this->issueFacade = $issueFacade;
		$this->user = $user;
	}


	public function create(\PeckaDesk\Model\Projects\Project $project): \Ublaboo\DataGrid\DataGrid
	{
		$dataGrid = $this->baseFactory->create();

		$source = new \Ublaboo\DataGrid\DataSource\DoctrineDataSource($this->issueFacade->queryFactory($project), 'id');
		$dataGrid->setDataSource($source);

		$dataGrid->addColumnText('name', 'name');

		if ($this->user->isAllowed($project, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_CREATE_ISSUE)) {
			$this->baseFactory->createAddButton($dataGrid, ':Dashboard:Issues:Add:', [$project]);
		}

		$this->baseFactory->createDetailButton($dataGrid, ':Dashboard:Issues:Detail:', function (\PeckaDesk\Model\Issues\Issue $issue): bool {
			return $this->user->isAllowed($issue->getProject(), \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_READ);
		});
		$this->baseFactory->createEditButton($dataGrid, ':Dashboard:Issues:Edit:', function (\PeckaDesk\Model\Issues\Issue $issue): bool {
			return $this->user->isAllowed($issue->getProject(), \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_EDIT);
		});

		return $dataGrid;
	}

}
