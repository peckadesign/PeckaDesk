<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Users\Grids;

final class Factory
{

	private \PeckaDesk\Dashboard\Grids\BaseFactory $baseFactory;

	private \PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade;


	public function __construct(
		\PeckaDesk\Dashboard\Grids\BaseFactory $baseFactory,
		\PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade
	)
	{
		$this->baseFactory = $baseFactory;
		$this->userFacade = $userFacade;
	}


	public function create(): \Ublaboo\DataGrid\DataGrid
	{
		$dataGrid = $this->baseFactory->create();

		$source = new \Ublaboo\DataGrid\DataSource\DoctrineDataSource($this->userFacade->queryFactory(), 'id');
		$dataGrid->setDataSource($source);

		$dataGrid->addColumnText('firstName', 'firstName');
		$dataGrid->addColumnText('lastName', 'lastName');

		$this->baseFactory->createAddButton($dataGrid, ':Dashboard:Users:Add:');

		$this->baseFactory->createDetailButton($dataGrid, ':Dashboard:Users:Detail:');
		$this->baseFactory->createEditButton($dataGrid, ':Dashboard:Users:Edit:');

		return $dataGrid;
	}

}
