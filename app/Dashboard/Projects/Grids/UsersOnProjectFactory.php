<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Projects\Grids;

final class UsersOnProjectFactory
{

	private \PeckaDesk\Dashboard\Grids\BaseFactory $baseFactory;

	private \PeckaDesk\Dashboard\UsersOnProjects\Model\UsersOnProjectsFacadeInterface $usersOnProjectsFacade;


	public function __construct(
		\PeckaDesk\Dashboard\Grids\BaseFactory $baseFactory,
		\PeckaDesk\Dashboard\UsersOnProjects\Model\UsersOnProjectsFacadeInterface $usersOnProjectsFacade
	)
	{
		$this->baseFactory = $baseFactory;
		$this->usersOnProjectsFacade = $usersOnProjectsFacade;
	}


	public function create(\PeckaDesk\Model\Projects\Project $project): \Ublaboo\DataGrid\DataGrid
	{
		$dataGrid = $this->baseFactory->create();

		$source = new \Ublaboo\DataGrid\DataSource\DoctrineDataSource($this->usersOnProjectsFacade->fetchUsersOnProjectQuery($project), 'user');
		$dataGrid->setDataSource($source);

		$cb = static function (\PeckaDesk\Model\UsersOnProjects\UserOnProject $userOnProject): string {
			return $userOnProject->getUser()->getFirstName() . ' ' . $userOnProject->getUser()->getLastName();
		};
		$dataGrid
			->addColumnText('user', 'user')
			->setRenderer($cb)
		;
		$dataGrid->addColumnText('role', 'role');

		return $dataGrid;
	}

}
