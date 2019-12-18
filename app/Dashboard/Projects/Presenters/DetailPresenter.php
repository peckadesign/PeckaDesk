<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Projects\Presenters;

final class DetailPresenter extends \PeckaDesk\Dashboard\Presenters\BasePresenter
{

	private \PeckaDesk\Model\Projects\Project $project;

	private \PeckaDesk\Dashboard\Issues\Grids\Factory $issueGridFactory;

	private \PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade;


	public function __construct(
		\PeckaDesk\Dashboard\Issues\Grids\Factory $issueGridFactory,
		\PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade
	)
	{
		$this->issueGridFactory = $issueGridFactory;
		$this->projectFacade = $projectFacade;
	}


	public function actionDefault(\PeckaDesk\Model\Projects\Project $project): void
	{
		$this->project = $project;
	}


	public function renderDefault(): void
	{
		$this
			->template
			->add('project', $this->project);
	}


	protected function createComponentIssueGrid(): \Ublaboo\DataGrid\DataGrid
	{
		return $this->issueGridFactory->create($this->project);
	}

}
