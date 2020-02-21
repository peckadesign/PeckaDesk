<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Controls\ChangeStatus;

/**
 * @method \Nette\Bridges\ApplicationLatte\Template getTemplate()
 */
final class Control extends \Nette\Application\UI\Control
{

	private \PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade;

	private \PeckaDesk\Model\Issues\Issue $issue;

	private \PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade;

	private \PeckaDesk\Dashboard\Issues\Forms\ChangeStatusFormFactory $changeStatusFormFactory;

	private \PeckaDesk\Model\DateTimeProviderInterface $dateTimeProvider;

	private \Nette\Security\User $user;


	public function __construct(
		\PeckaDesk\Model\Issues\Issue $issue,
		\PeckaDesk\Dashboard\Issues\Forms\ChangeStatusFormFactory $changeStatusFormFactory,
		\PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade,
		\PeckaDesk\Model\DateTimeProviderInterface $dateTimeProvider,
		\Nette\Security\User $user
	)
	{
		$this->changeStatusFormFactory = $changeStatusFormFactory;
		$this->issueFacade = $issueFacade;
		$this->issue = $issue;
		$this->dateTimeProvider = $dateTimeProvider;
		$this->user = $user;
	}


	public function render(): void
	{
		$this
			->getTemplate()
			->setFile(__DIR__ . '/Control.latte')
			->add('show', $this->issue->getStatus()->getStatus() !== \PeckaDesk\Model\Issues\Status::STATUS_FINISHED)
			->render()
		;
	}


	protected function createComponentChangeStatusForm(): \Nette\Application\UI\Form
	{
		$cb = function (string $status) {
			$this->issueFacade->changeStatus($this->issue, $status, $this->user->getIdentity());
			$this->getPresenter()->flashMessage('saved', 'success');
			$this->redirect('this');
		};

		return $this->changeStatusFormFactory->create($this->issue, $cb);
	}

}
