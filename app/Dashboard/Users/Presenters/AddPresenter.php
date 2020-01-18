<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Users\Presenters;

final class AddPresenter extends \PeckaDesk\Dashboard\Presenters\BasePresenter
{

	private \PeckaDesk\Dashboard\Users\Forms\AddFormFactory $formFactory;

	private \PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade;


	public function __construct(
		\PeckaDesk\Dashboard\Users\Forms\AddFormFactory $formFactory,
		\PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade
	)
	{
		parent::__construct();
		$this->formFactory = $formFactory;
		$this->userFacade = $userFacade;
	}


	public function actionDefault(): void
	{
	}


	protected function createComponentForm(): \Nette\Application\UI\Form
	{
		$form = $this->formFactory->create();

		$form->addSubmit('save', 'save')->onClick[] = function (\Nette\Forms\Controls\SubmitButton $button) use ($form): void {
			/** @var \PeckaDesk\Dashboard\Users\Forms\AddFormValues $values */
			$values = $form->getValues(\PeckaDesk\Dashboard\Users\Forms\AddFormValues::class);
			$user = $this->userFacade->saveFromAddForm($values);
			$this->flashMessage('saved', 'success');
			$this->redirect(':Dashboard:Users:Detail:', $user);
		};

		return $form;
	}

}
