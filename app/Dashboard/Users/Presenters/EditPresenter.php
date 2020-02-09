<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Users\Presenters;

final class EditPresenter extends \PeckaDesk\Dashboard\Presenters\BasePresenter
{

	private \PeckaDesk\Dashboard\Users\Forms\EditFormFactory $formFactory;

	private \PeckaDesk\Model\Users\User $person;

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
		if ( ! $this->getUser()->isAllowed(\PeckaDesk\Dashboard\Users\AclFactory::RESOURCE_USERS, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_EDIT)) {
			throw new \Nette\Application\ForbiddenRequestException();
		}

		$this->person = $user;

		$this['form']->setDefaults(\PeckaDesk\Dashboard\Users\Forms\EditFormValues::createFromUser($this->person));
	}


	protected function createComponentForm(): \Nette\Application\UI\Form
	{
		$form = $this->formFactory->create();

		$form->addSubmit('save', 'save')->onClick[] = function (\Nette\Forms\Controls\SubmitButton $button) use ($form): void {
			/** @var \PeckaDesk\Dashboard\Users\Forms\EditFormValues $values */
			$values = $form->getValues(\PeckaDesk\Dashboard\Users\Forms\EditFormValues::class);
			$this->userFacade->saveFromEditForm($this->person, $values);
			$this->flashMessage('saved', 'success');
			$this->redirect('this');
		};

		return $form;
	}

}
