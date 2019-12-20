<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Projects\Grids;

final class Factory
{

	private \PeckaDesk\Dashboard\Grids\BaseFactory $baseFactory;

	private \PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade;


	public function __construct(
		\PeckaDesk\Dashboard\Grids\BaseFactory $baseFactory,
		\PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade
	)
	{
		$this->baseFactory = $baseFactory;
		$this->projectFacade = $projectFacade;
	}


	public function create(): \Ublaboo\DataGrid\DataGrid
	{
		$dataGrid = $this->baseFactory->create();

		$source = new \Ublaboo\DataGrid\DataSource\DoctrineDataSource($this->projectFacade->queryFactory(), 'id');
		$dataGrid->setDataSource($source);

		$dataGrid->addColumnText('name', 'name');

		$this->baseFactory->createAddButton($dataGrid, ':Dashboard:Projects:Add:');

		$this->baseFactory->createDetailButton($dataGrid, ':Dashboard:Projects:Detail:');
		$this->baseFactory->createEditButton($dataGrid, ':Dashboard:Projects:Edit:');

		return $dataGrid;
	}

}
