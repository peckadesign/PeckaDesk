<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Navigation;

final class Factory
{

	private \PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade;

	private \PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade;

	private \PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade;


	public function __construct(
		\PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade,
		\PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade,
		\PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade
	)
	{
		$this->projectFacade = $projectFacade;
		$this->issueFacade = $issueFacade;
		$this->userFacade = $userFacade;
	}


	public function create(\Nette\Application\UI\Presenter $presenter): Node
	{
		$navigation = new Node();

		$user = $presenter->getUser();

		$nodeProjects = new Node();
		$nodeProjects->setLabel('projects');
		$nodeProjects->setLink(':Dashboard:Projects:List', 'default');
		$nodeProjects->setAllowed($user->isAllowed(\PeckaDesk\Dashboard\Users\AclFactory::RESOURCE_PROJECTS, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_READ));
		$nodeProjects->setSelected($presenter instanceof \PeckaDesk\Dashboard\Projects\Presenters\ListPresenter);
		$navigation->addChild($nodeProjects);

		$addProject = new Node();
		$addProject->setLabel('add');
		$addProject->setLink(':Dashboard:Projects:Add', 'default');
		$addProject->setAllowed($user->isAllowed(\PeckaDesk\Dashboard\Users\AclFactory::RESOURCE_PROJECTS, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_ADD));
		$addProject->setSelected($presenter instanceof \PeckaDesk\Dashboard\Projects\Presenters\AddPresenter);
		$nodeProjects->addChild($addProject);

		foreach ($this->projectFacade->fetchAll() as $project) {
			$nodeProject = new Node();
			$nodeProject->setLabel($project->getName());
			$nodeProject->setLink(':Dashboard:Projects:Detail', 'default', [$project]);
			$nodeProject->setAllowed($user->isAllowed($project, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_READ));
			$nodeProject->setSelected($presenter instanceof \PeckaDesk\Dashboard\Projects\Presenters\DetailPresenter && $presenter->getParameter('project')->getId() === $project->getId());
			$nodeProjects->addChild($nodeProject);

			$node = new Node();
			$node->setLabel('addIssue');
			$node->setLink(':Dashboard:Issues:Add', 'default', [$project]);
			$node->setAllowed($user->isAllowed($project, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_CREATE_ISSUE));
			$node->setSelected($presenter instanceof \PeckaDesk\Dashboard\Issues\Presenters\AddPresenter && $presenter->getParameter('project')->getId() === $project->getId());
			$nodeProject->addChild($node);

			$node = new Node();
			$node->setLabel('edit');
			$node->setLink(':Dashboard:Projects:Edit', 'default', [$project]);
			$node->setAllowed($user->isAllowed(\PeckaDesk\Dashboard\Users\AclFactory::RESOURCE_PROJECTS, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_EDIT));
			$node->setSelected($presenter instanceof \PeckaDesk\Dashboard\Projects\Presenters\EditPresenter && $presenter->getParameter('project')->getId() === $project->getId());
			$nodeProject->addChild($node);

			$projectIssues = $this->issueFacade->fetchAll($project);

			$nodeProject->setBadge((string) \count($projectIssues), Node::BADGE_STATE_INFO);

			foreach ($projectIssues as $issue) {
				$nodeIssue = new Node();
				$nodeIssue->setLabel($issue->getName());
				$nodeIssue->setLink(':Dashboard:Issues:Detail', 'default', [$issue]);
				$nodeIssue->setAllowed($user->isAllowed($project, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_READ));
				$nodeIssue->setSelected($presenter instanceof \PeckaDesk\Dashboard\Issues\Presenters\DetailPresenter && $presenter->getParameter('issue')->getId() === $issue->getId());
				$nodeProject->addChild($nodeIssue);

				$node = new Node();
				$node->setLabel('edit');
				$node->setLink(':Dashboard:Issues:Edit', 'default', [$issue]);
				$node->setAllowed($user->isAllowed($project, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_EDIT));
				$node->setSelected($presenter instanceof \PeckaDesk\Dashboard\Issues\Presenters\EditPresenter && $presenter->getParameter('issue')->getId() === $issue->getId());
				$nodeIssue->addChild($node);
			}

			$nodeUsers = new Node();
			$nodeUsers->setLabel('users');
			$nodeUsers->setLink(':Dashboard:Users:List', 'default');
			$nodeUsers->setAllowed($user->isAllowed(\PeckaDesk\Dashboard\Users\AclFactory::RESOURCE_USERS, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_READ));
			$nodeUsers->setSelected($presenter instanceof \PeckaDesk\Dashboard\Users\Presenters\ListPresenter);
			$navigation->addChild($nodeUsers);

			$nodeAddUser = new Node();
			$nodeAddUser->setLabel('add');
			$nodeAddUser->setLink(':Dashboard:Users:Add', 'default');
			$nodeAddUser->setAllowed($user->isAllowed(\PeckaDesk\Dashboard\Users\AclFactory::RESOURCE_USERS, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_ADD));
			$nodeAddUser->setSelected($presenter instanceof \PeckaDesk\Dashboard\Users\Presenters\AddPresenter);
			$nodeUsers->addChild($nodeAddUser);

			$users = $this->userFacade->fetchAll();
			foreach ($users as $person) {
				$nodeUser = new Node();
				$nodeUser->setLabel($person->getFirstName() . ' ' . $person->getLastName());
				$nodeUser->setLink(':Dashboard:Users:Detail', 'default', [$person]);
				$nodeUser->setAllowed($user->isAllowed(\PeckaDesk\Dashboard\Users\AclFactory::RESOURCE_USERS, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_READ));
				$nodeUser->setSelected($presenter instanceof \PeckaDesk\Dashboard\Users\Presenters\DetailPresenter && $presenter->getParameter('user')->getId() === $person->getId());
				$nodeUsers->addChild($nodeUser);

				$node = new Node();
				$node->setLabel('edit');
				$node->setLink(':Dashboard:Users:Edit', 'default', [$person]);
				$node->setAllowed($user->isAllowed(\PeckaDesk\Dashboard\Users\AclFactory::RESOURCE_USERS, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_EDIT));
				$node->setSelected($presenter instanceof \PeckaDesk\Dashboard\Users\Presenters\EditPresenter && $presenter->getParameter('user')->getId() === $person->getId());
				$nodeUser->addChild($node);
			}
		}

		return $navigation;
	}

}
