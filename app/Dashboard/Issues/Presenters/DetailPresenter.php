<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Presenters;

final class DetailPresenter extends \PeckaDesk\Dashboard\Presenters\BasePresenter
{

	private \PeckaDesk\Model\Issues\Issue $issue;

	private \PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade;


	public function __construct(
		\PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade
	)
	{
		parent::__construct();
		$this->issueFacade = $issueFacade;
	}


	public function actionDefault(\PeckaDesk\Model\Issues\Issue $issue): void
	{
		$this->issue = $issue;
	}


	public function renderDefault(): void
	{
		$this
			->template
			->add('issue', $this->issue);
	}

}
