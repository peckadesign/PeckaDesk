<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Controls\ReplyComment;

/**
 * @method \Nette\Bridges\ApplicationLatte\Template getTemplate()
 */
final class Control extends \Nette\Application\UI\Control
{

	private \PeckaDesk\Dashboard\Issues\Forms\ReplyFormFactory $replyFormFactory;

	private \PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade;

	private \PeckaDesk\Model\Issues\Issue $issue;

	private \PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade;


	public function __construct(
		\PeckaDesk\Model\Issues\Issue $issue,
		\PeckaDesk\Dashboard\Issues\Forms\ReplyFormFactory $replyFormFactory,
		\PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade,
		\PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade
	)
	{
		$this->replyFormFactory = $replyFormFactory;
		$this->issueFacade = $issueFacade;
		$this->issue = $issue;
		$this->userFacade = $userFacade;
	}


	public function render(): void
	{
		$this
			->getTemplate()
			->setFile(__DIR__ . '/Control.latte')
			->render()
		;
	}


	protected function createComponentReply(): \Nette\Application\UI\Form
	{
		$form = $this->replyFormFactory->create();
		$form->addSubmit('save', 'save')->onClick[] = function (\Nette\Forms\Controls\SubmitButton $button) use ($form): void {
			/** @var \PeckaDesk\Dashboard\Issues\Forms\ReplyFormValues $values */
			$values = $form->getValues(\PeckaDesk\Dashboard\Issues\Forms\ReplyFormValues::class);
			$createdBy = $this->userFacade->getById($this->getPresenter()->getUser()->getId());
			$comment = $this->issueFacade->saveReplyForm($createdBy, $this->issue, $values);
			$this->getPresenter()->flashMessage('saved', 'success');
			$this->getPresenter()->redirect(':Dashboard:Issues:Detail:', [$this->issue]);
		};

		return $form;
	}

}
