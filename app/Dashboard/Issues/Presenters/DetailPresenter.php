<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Presenters;

final class DetailPresenter extends \PeckaDesk\Dashboard\Presenters\BasePresenter
{

	private \PeckaDesk\Model\Issues\Issue $issue;

	private \PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade;

	private \PeckaDesk\Dashboard\Controls\ReplyComment\FactoryInterface $replyCommentControlFactory;


	public function __construct(
		\PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade,
		\PeckaDesk\Dashboard\Controls\ReplyComment\FactoryInterface $replyCommentControlFactory
	)
	{
		parent::__construct();
		$this->issueFacade = $issueFacade;
		$this->replyCommentControlFactory = $replyCommentControlFactory;
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


	protected function createComponentReply(): \PeckaDesk\Dashboard\Controls\ReplyComment\Control
	{
		return $this->replyCommentControlFactory->create($this->issue);
	}

}
