<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Navigation;

final class Factory
{

	private \PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade;

	/**
	 * @var \PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface
	 */
	private \PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade;


	public function __construct(
		\PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade,
		\PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade
	)
	{
		$this->projectFacade = $projectFacade;
		$this->issueFacade = $issueFacade;
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
		}

		return $navigation;
	}

}
