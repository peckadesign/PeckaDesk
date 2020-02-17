<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Users;

final class AclFactory
{

	public const RESOURCE_PROJECTS = 'projects';
	public const RESOURCE_USERS = 'users';

	public const PERMISSION_ADD = 'add';
	public const PERMISSION_READ = 'read';
	public const PERMISSION_REPLY = 'reply';
	public const PERMISSION_CREATE_ISSUE = 'createIssue';
	public const PERMISSION_EDIT = 'edit';

	private \PeckaDesk\Dashboard\UsersOnProjects\Model\UsersOnProjectsFacadeInterface $usersOnProjectsFacade;

	private Model\UserFacadeInterface $userFacade;

	private \PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade;


	public function __construct(
		\PeckaDesk\Dashboard\UsersOnProjects\Model\UsersOnProjectsFacadeInterface $usersOnProjectsFacade,
		\PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade,
		\PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade
	)
	{
		$this->usersOnProjectsFacade = $usersOnProjectsFacade;
		$this->userFacade = $userFacade;
		$this->projectFacade = $projectFacade;
	}


	public function create(): \Nette\Security\IAuthorizator
	{
		$permission = new \Nette\Security\Permission();

		$permission->addRole(\PeckaDesk\Model\Users\User::ROLE_ADMINISTRATOR);
		$permission->addRole(\PeckaDesk\Model\Users\User::ROLE_AUTHENTICATED);

		$permission->addResource(self::RESOURCE_USERS);
		$permission->addResource(self::RESOURCE_PROJECTS);

		foreach ($this->projectFacade->fetchAll() as $project) {
			$permission->addResource($project->getResourceId());
		}

		$usersOnProjects = $this->usersOnProjectsFacade->fetchAll();

		foreach ($usersOnProjects as $userOnProject) {
			$permission->addRole($userOnProject->getRoleId());

			$permission->allow($userOnProject->getRoleId(), self::RESOURCE_PROJECTS, self::PERMISSION_READ);

			if ($userOnProject->getRole() === \PeckaDesk\Model\Users\User::ROLE_SUPPORT) {
				$permission->allow($userOnProject->getRoleId(), $userOnProject->getProject()->getResourceId(), self::PERMISSION_READ);
				$permission->allow($userOnProject->getRoleId(), $userOnProject->getProject()->getResourceId(), self::PERMISSION_REPLY);
			} elseif ($userOnProject->getRole() === \PeckaDesk\Model\Users\User::ROLE_ADMINISTRATOR) {
				$permission->allow($userOnProject->getRoleId(), $userOnProject->getProject()->getResourceId(), \Nette\Security\Permission::ALL);
			} elseif ($userOnProject->getRole() === \PeckaDesk\Model\Users\User::ROLE_CLIENT) {
				$permission->allow($userOnProject->getRoleId(), $userOnProject->getProject()->getResourceId(), self::PERMISSION_READ);
				$permission->allow($userOnProject->getRoleId(), $userOnProject->getProject()->getResourceId(), self::PERMISSION_CREATE_ISSUE);
			}
		}

		$permission->allow(\PeckaDesk\Model\Users\User::ROLE_ADMINISTRATOR);

		return $permission;
	}

}
