<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Projects\Presenters;

final class EditPresenter extends \PeckaDesk\Dashboard\Presenters\BasePresenter
{

	private \PeckaDesk\Dashboard\Projects\Forms\EditFormFactory $formFactory;

	private \PeckaDesk\Model\Projects\Project $project;

	private \PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade;

	private \PeckaDesk\Dashboard\Projects\Forms\AddUserFormFactory $addUserFormFactory;

	private \PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade;

	private \PeckaDesk\Dashboard\Projects\Grids\UsersOnProjectFactory $usersOnProjectGridFactory;


	public function __construct(
		\PeckaDesk\Dashboard\Projects\Forms\EditFormFactory $formFactory,
		\PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade,
		\PeckaDesk\Dashboard\Projects\Forms\AddUserFormFactory $addUserFormFactory,
		\PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade,
		\PeckaDesk\Dashboard\Projects\Grids\UsersOnProjectFactory $usersOnProjectGridFactory
	)
	{
		parent::__construct();
		$this->formFactory = $formFactory;
		$this->projectFacade = $projectFacade;
		$this->addUserFormFactory = $addUserFormFactory;
		$this->userFacade = $userFacade;
		$this->usersOnProjectGridFactory = $usersOnProjectGridFactory;
	}


	public function actionDefault(\PeckaDesk\Model\Projects\Project $project): void
	{
		if ( ! $this->getUser()->isAllowed($project, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_EDIT)) {
			throw new \Nette\Application\ForbiddenRequestException();
		}

		$this->project = $project;

		$this['form']->setDefaults(\PeckaDesk\Dashboard\Projects\Forms\EditFormValues::createFromProject($this->project));
	}


	protected function createComponentForm(): \Nette\Application\UI\Form
	{
		$form = $this->formFactory->create();

		$form->addSubmit('save', 'save')->onClick[] = function (\Nette\Forms\Controls\SubmitButton $button) use ($form): void {
			/** @var \PeckaDesk\Dashboard\Projects\Forms\EditFormValues $values */
			$values = $form->getValues(\PeckaDesk\Dashboard\Projects\Forms\EditFormValues::class);
			$this->projectFacade->saveFromEditForm($this->project, $values);
			$this->flashMessage('saved', 'success');
			$this->redirect('this');
		};

		return $form;
	}


	protected function createComponentAddUserForm(): \Nette\Application\UI\Form
	{
		$form = $this->addUserFormFactory->create();

		$form->addSubmit('save', 'save')->onClick[] = function (\Nette\Forms\Controls\SubmitButton $button) use ($form): void {
			/** @var \PeckaDesk\Dashboard\Projects\Forms\AddUserFormValues $values */
			$values = $form->getValues(\PeckaDesk\Dashboard\Projects\Forms\AddUserFormValues::class);
			$this->projectFacade->addUserToProject($this->project, $form[\PeckaDesk\Dashboard\Projects\Forms\AddUserFormFactory::CONTROL_USER]->getSelectedItem()->getUser(), $values->role);
			$this->flashMessage('saved', 'success');
			$this->redirect('this');
		};

		return $form;
	}


	protected function createComponentUsersOnProjectGrid(): \Ublaboo\DataGrid\DataGrid
	{
		return $this->usersOnProjectGridFactory->create($this->project);
	}

}
