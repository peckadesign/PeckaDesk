<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Grids;

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


	public function create(\PeckaDesk\Model\Projects\Project $project): \Ublaboo\DataGrid\DataGrid
	{
		$dataGrid = $this->baseFactory->create();

		$qb = $this->entityManager->createQueryBuilder();
		$qb->select('i')->from(\PeckaDesk\Model\Issues\Issue::class, 'i');
		$qb->where('i.project = ?1');
		$qb->setParameter(1, $project);
		$source = new \Ublaboo\DataGrid\DataSource\DoctrineDataSource($qb, 'id');
		$dataGrid->setDataSource($source);

		$dataGrid->addColumnText('name', 'name');

		$this->baseFactory->createAddButton($dataGrid, ':Dashboard:Issues:Add:', [$project]);

		$this->baseFactory->createDetailButton($dataGrid, ':Dashboard:Issues:Detail:');
		$this->baseFactory->createEditButton($dataGrid, ':Dashboard:Issues:Edit:');

		return $dataGrid;
	}

}
