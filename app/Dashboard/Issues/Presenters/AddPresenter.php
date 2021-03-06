<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Presenters;

final class AddPresenter extends \PeckaDesk\Dashboard\Presenters\BasePresenter
{

	private \PeckaDesk\Dashboard\Issues\Forms\AddFormFactory $formFactory;

	private \PeckaDesk\Model\Projects\Project $project;

	private \PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade;

	private \PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade;

	private \PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade;


	public function __construct(
		\PeckaDesk\Dashboard\Issues\Forms\AddFormFactory $formFactory,
		\PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade,
		\PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade,
		\PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade
	)
	{
		parent::__construct();
		$this->formFactory = $formFactory;
		$this->projectFacade = $projectFacade;
		$this->issueFacade = $issueFacade;
		$this->userFacade = $userFacade;
	}


	public function actionDefault(\PeckaDesk\Model\Projects\Project $project): void
	{
		if ( ! $this->getUser()->isAllowed($project, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_CREATE_ISSUE)) {
			throw new \Nette\Application\ForbiddenRequestException();
		}

		$this->project = $project;
	}


	protected function createComponentForm(): \Nette\Application\UI\Form
	{
		$form = $this->formFactory->create();

		$form->addSubmit('save', 'save')->onClick[] = function (\Nette\Forms\Controls\SubmitButton $button) use ($form): void {
			/** @var \PeckaDesk\Dashboard\Issues\Forms\AddFormValues $values */
			$values = $form->getValues(\PeckaDesk\Dashboard\Issues\Forms\AddFormValues::class);
			$createdBy = $this->userFacade->getById($this->getPresenter()->getUser()->getId());
			$issue = $this->issueFacade->saveFromAddForm($createdBy, $this->project, $values);
			$this->flashMessage('saved', 'success');
			$this->redirect(':Dashboard:Issues:Edit:', [$issue]);
		};

		return $form;
	}

}
