<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Users;

final class AclFactory
{

	public const PERMISSION_READ = 'read';
	public const PERMISSION_REPLY = 'reply';

	private \PeckaDesk\Dashboard\UsersOnProjects\Model\UsersOnProjectsFacadeInterface $usersOnProjectsFacade;


	public function __construct(
		\PeckaDesk\Dashboard\UsersOnProjects\Model\UsersOnProjectsFacadeInterface $usersOnProjectsFacade
	)
	{
		$this->usersOnProjectsFacade = $usersOnProjectsFacade;
	}


	public function create(): \Nette\Security\IAuthorizator
	{
		$permission = new \Nette\Security\Permission();

		$usersOnProjects = $this->usersOnProjectsFacade->fetchAll();

		foreach ($usersOnProjects as $userOnProject) {
			$permission->addResource($userOnProject->getProject()->getResourceId());
			$permission->addRole($userOnProject->getRoleId());

			if ($userOnProject->getRole() === \PeckaDesk\Model\Users\User::ROLE_SUPPORT) {
				$permission->allow($userOnProject->getRoleId(), $userOnProject->getProject()->getResourceId(), self::PERMISSION_READ);
				$permission->allow($userOnProject->getRoleId(), $userOnProject->getProject()->getResourceId(), self::PERMISSION_REPLY);
			} elseif ($userOnProject->getRole() === \PeckaDesk\Model\Users\User::ROLE_ADMINISTRATOR) {
				$permission->allow($userOnProject->getRoleId(), $userOnProject->getProject()->getResourceId(), \Nette\Security\Permission::ALL);
			}
		}

		return $permission;
	}

}
