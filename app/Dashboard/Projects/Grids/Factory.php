<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Projects\Grids;

final class Factory
{

	private \PeckaDesk\Dashboard\Grids\BaseFactory $baseFactory;

	private \Doctrine\ORM\EntityManagerInterface $entityManager;


	public function __construct(
		\PeckaDesk\Dashboard\Grids\BaseFactory $baseFactory,
		\Doctrine\ORM\EntityManagerInterface $entityManager
	)
	{
		$this->baseFactory = $baseFactory;
		$this->entityManager = $entityManager;
	}


	public function create(): \Ublaboo\DataGrid\DataGrid
	{
		$dataGrid = $this->baseFactory->create();

		$qb = $this->entityManager->createQueryBuilder();
		$qb->select('p')->from(\PeckaDesk\Model\Projects\Project::class, 'p');
		$source = new \Ublaboo\DataGrid\DataSource\DoctrineDataSource($qb, 'id');
		$dataGrid->setDataSource($source);

		$dataGrid->addColumnText('name', 'name');

		$this->baseFactory->createAddButton($dataGrid, ':Dashboard:Projects:Add:');

		$this->baseFactory->createDetailButton($dataGrid, ':Dashboard:Projects:Detail:');
		$this->baseFactory->createEditButton($dataGrid, ':Dashboard:Projects:Edit:');

		return $dataGrid;
	}

}
