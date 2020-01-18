<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Users\Presenters;

final class EditPresenter extends \PeckaDesk\Dashboard\Presenters\BasePresenter
{

	private \PeckaDesk\Dashboard\Users\Forms\EditFormFactory $formFactory;

	private \PeckaDesk\Model\Users\User $user;

	private \PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade;


	public function __construct(
		\PeckaDesk\Dashboard\Users\Forms\EditFormFactory $formFactory,
		\PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade
	)
	{
		parent::__construct();
		$this->formFactory = $formFactory;
		$this->userFacade = $userFacade;
	}


	public function actionDefault(\PeckaDesk\Model\Users\User $user): void
	{
		$this->user = $user;

		$this['form']->setDefaults(\PeckaDesk\Dashboard\Users\Forms\EditFormValues::createFromUser($this->user));
	}


	protected function createComponentForm(): \Nette\Application\UI\Form
	{
		$form = $this->formFactory->create();

		$form->addSubmit('save', 'save')->onClick[] = function (\Nette\Forms\Controls\SubmitButton $button) use ($form): void {
			/** @var \PeckaDesk\Dashboard\Users\Forms\EditFormValues $values */
			$values = $form->getValues(\PeckaDesk\Dashboard\Users\Forms\EditFormValues::class);
			$this->userFacade->saveFromEditForm($this->user, $values);
			$this->flashMessage('saved', 'success');
			$this->redirect('this');
		};

		return $form;
	}

}
