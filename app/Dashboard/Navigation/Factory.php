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

		$nodeProjects = new Node();
		$nodeProjects->setLabel('projects');
		$nodeProjects->setLink(':Dashboard:Projects:List', 'default');
		$nodeProjects->setAllowed(TRUE);
		$nodeProjects->setSelected($presenter instanceof \PeckaDesk\Dashboard\Projects\Presenters\ListPresenter);
		$navigation->addChild($nodeProjects);

		$addProject = new Node();
		$addProject->setLabel('add');
		$addProject->setLink(':Dashboard:Projects:Add', 'default');
		$addProject->setAllowed(TRUE);
		$addProject->setSelected($presenter instanceof \PeckaDesk\Dashboard\Projects\Presenters\AddPresenter);
		$nodeProjects->addChild($addProject);

		foreach ($this->projectFacade->fetchAll() as $project) {
			$nodeProject = new Node();
			$nodeProject->setLabel($project->getName());
			$nodeProject->setLink(':Dashboard:Projects:Detail', 'default', [$project]);
			$nodeProject->setAllowed(TRUE);
			$nodeProject->setSelected($presenter instanceof \PeckaDesk\Dashboard\Projects\Presenters\DetailPresenter && $presenter->getParameter('project')->getId() === $project->getId());
			$nodeProjects->addChild($nodeProject);

			$node = new Node();
			$node->setLabel('addIssue');
			$node->setLink(':Dashboard:Issues:Add', 'default', [$project]);
			$node->setAllowed(TRUE);
			$node->setSelected($presenter instanceof \PeckaDesk\Dashboard\Issues\Presenters\AddPresenter && $presenter->getParameter('project')->getId() === $project->getId());
			$nodeProject->addChild($node);

			$node = new Node();
			$node->setLabel('edit');
			$node->setLink(':Dashboard:Projects:Edit', 'default', [$project]);
			$node->setAllowed(TRUE);
			$node->setSelected($presenter instanceof \PeckaDesk\Dashboard\Projects\Presenters\EditPresenter && $presenter->getParameter('project')->getId() === $project->getId());
			$nodeProject->addChild($node);

			$projectIssues = $this->issueFacade->fetchAll($project);

			$nodeProject->setBadge((string) \count($projectIssues), Node::BADGE_STATE_INFO);

			foreach ($projectIssues as $issue) {
				$nodeIssue = new Node();
				$nodeIssue->setLabel($issue->getName());
				$nodeIssue->setLink(':Dashboard:Issues:Detail', 'default', [$issue]);
				$nodeIssue->setAllowed(TRUE);
				$nodeIssue->setSelected($presenter instanceof \PeckaDesk\Dashboard\Issues\Presenters\DetailPresenter && $presenter->getParameter('issue')->getId() === $issue->getId());
				$nodeProject->addChild($nodeIssue);

				$node = new Node();
				$node->setLabel('edit');
				$node->setLink(':Dashboard:Issues:Edit', 'default', [$issue]);
				$node->setAllowed(TRUE);
				$node->setSelected($presenter instanceof \PeckaDesk\Dashboard\Issues\Presenters\EditPresenter && $presenter->getParameter('issue')->getId() === $issue->getId());
				$nodeIssue->addChild($node);
			}

			$nodeUsers = new Node();
			$nodeUsers->setLabel('users');
			$nodeUsers->setLink(':Dashboard:Users:List', 'default');
			$nodeUsers->setAllowed(TRUE);
			$nodeUsers->setSelected($presenter instanceof \PeckaDesk\Dashboard\Users\Presenters\ListPresenter);
			$navigation->addChild($nodeUsers);

			$nodeAddUser = new Node();
			$nodeAddUser->setLabel('add');
			$nodeAddUser->setLink(':Dashboard:Users:Add', 'default');
			$nodeAddUser->setAllowed(TRUE);
			$nodeAddUser->setSelected($presenter instanceof \PeckaDesk\Dashboard\Users\Presenters\AddPresenter);
			$navigation->addChild($nodeAddUser);

			$users = $this->userFacade->fetchAll();
			foreach ($users as $user) {
				$nodeUser = new Node();
				$nodeUser->setLabel($user->getFirstName() . ' ' . $user->getLastName());
				$nodeUser->setLink(':Dashboard:Users:Detail', 'default', [$user]);
				$nodeUser->setAllowed(TRUE);
				$nodeUser->setSelected($presenter instanceof \PeckaDesk\Dashboard\Users\Presenters\DetailPresenter && $presenter->getParameter('user')->getId() === $user->getId());
				$nodeUsers->addChild($nodeUser);

				$node = new Node();
				$node->setLabel('edit');
				$node->setLink(':Dashboard:Users:Edit', 'default', [$user]);
				$node->setAllowed(TRUE);
				$node->setSelected($presenter instanceof \PeckaDesk\Dashboard\Users\Presenters\EditPresenter && $presenter->getParameter('user')->getId() === $user->getId());
				$nodeUser->addChild($node);
			}
		}

		return $navigation;
	}

}
