<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Users\Grids;

final class Factory
{

	private \PeckaDesk\Dashboard\Grids\BaseFactory $baseFactory;

	private \PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade;

	private \Nette\Security\User $user;


	public function __construct(
		\PeckaDesk\Dashboard\Grids\BaseFactory $baseFactory,
		\PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade,
		\Nette\Security\User $user
	)
	{
		$this->baseFactory = $baseFactory;
		$this->userFacade = $userFacade;
		$this->user = $user;
	}


	public function create(): \Ublaboo\DataGrid\DataGrid
	{
		$dataGrid = $this->baseFactory->create();

		$source = new \Ublaboo\DataGrid\DataSource\DoctrineDataSource($this->userFacade->queryFactory(), 'id');
		$dataGrid->setDataSource($source);

		$dataGrid->addColumnText('firstName', 'firstName');
		$dataGrid->addColumnText('lastName', 'lastName');

		$this->baseFactory->createAddButton($dataGrid, ':Dashboard:Users:Add:');

		$this->baseFactory->createDetailButton($dataGrid, ':Dashboard:Users:Detail:', function (\PeckaDesk\Model\Users\User $user): bool {
			return $this->user->isAllowed(\PeckaDesk\Dashboard\Users\AclFactory::RESOURCE_USERS, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_READ);
		});
		$this->baseFactory->createEditButton($dataGrid, ':Dashboard:Users:Edit:', function (\PeckaDesk\Model\Users\User $user): bool {
			return $this->user->isAllowed(\PeckaDesk\Dashboard\Users\AclFactory::RESOURCE_USERS, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_EDIT);
		});

		return $dataGrid;
	}

}
