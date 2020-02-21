<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Presenters;

final class DetailPresenter extends \PeckaDesk\Dashboard\Presenters\BasePresenter
{

	private \PeckaDesk\Model\Issues\Issue $issue;

	private \PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade;

	private \PeckaDesk\Dashboard\Controls\ReplyComment\FactoryInterface $replyCommentControlFactory;

	private \PeckaDesk\Dashboard\Issues\Controls\ChangeStatus\FactoryInterface $changeStatusControlFactory;


	public function __construct(
		\PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade,
		\PeckaDesk\Dashboard\Controls\ReplyComment\FactoryInterface $replyCommentControlFactory,
		\PeckaDesk\Dashboard\Issues\Controls\ChangeStatus\FactoryInterface $changeStatusControlFactory
	)
	{
		parent::__construct();
		$this->issueFacade = $issueFacade;
		$this->replyCommentControlFactory = $replyCommentControlFactory;
		$this->changeStatusControlFactory = $changeStatusControlFactory;
	}


	public function actionDefault(\PeckaDesk\Model\Issues\Issue $issue): void
	{
		if ( ! $this->getUser()->isAllowed($issue->getProject(), \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_READ)) {
			throw new \Nette\Application\ForbiddenRequestException();
		}

		$this->issue = $issue;
	}


	public function renderDefault(): void
	{
		$this
			->template
			->add('issue', $this->issue)
			->add('posts', $this->issueFacade->loadIssuePosts($this->issue))
		;
	}


	protected function createComponentReply(): \PeckaDesk\Dashboard\Controls\ReplyComment\Control
	{
		return $this->replyCommentControlFactory->create($this->issue);
	}


	protected function createComponentChangeStatus(): \PeckaDesk\Dashboard\Issues\Controls\ChangeStatus\Control
	{
		return $this->changeStatusControlFactory->create($this->issue);
	}

}
