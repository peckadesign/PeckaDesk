<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Grids;

final class Factory
{

	private \PeckaDesk\Dashboard\Grids\BaseFactory $baseFactory;

	/**
	 * @var \PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface
	 */
	private \PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade;


	public function __construct(
		\PeckaDesk\Dashboard\Grids\BaseFactory $baseFactory,
		\PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade
	)
	{
		$this->baseFactory = $baseFactory;
		$this->issueFacade = $issueFacade;
	}


	public function create(\PeckaDesk\Model\Projects\Project $project): \Ublaboo\DataGrid\DataGrid
	{
		$dataGrid = $this->baseFactory->create();

		$source = new \Ublaboo\DataGrid\DataSource\DoctrineDataSource($this->issueFacade->queryFactory($project), 'id');
		$dataGrid->setDataSource($source);

		$dataGrid->addColumnText('name', 'name');

		$this->baseFactory->createAddButton($dataGrid, ':Dashboard:Issues:Add:', [$project]);

		$this->baseFactory->createDetailButton($dataGrid, ':Dashboard:Issues:Detail:');
		$this->baseFactory->createEditButton($dataGrid, ':Dashboard:Issues:Edit:');

		return $dataGrid;
	}

}
