<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Presenters;

final class AddPresenter extends \PeckaDesk\Dashboard\Presenters\BasePresenter
{

	private \PeckaDesk\Dashboard\Issues\Forms\AddFormFactory $formFactory;

	private \PeckaDesk\Model\Projects\Project $project;

	private \PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade;

	private \PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade;


	public function __construct(
		\PeckaDesk\Dashboard\Issues\Forms\AddFormFactory $formFactory,
		\PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade,
		\PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade
	)
	{
		parent::__construct();
		$this->formFactory = $formFactory;
		$this->projectFacade = $projectFacade;
		$this->issueFacade = $issueFacade;
	}


	public function actionDefault(\PeckaDesk\Model\Projects\Project $project): void
	{
		$this->project = $project;
	}


	protected function createComponentForm(): \Nette\Application\UI\Form
	{
		$form = $this->formFactory->create();

		$form->addSubmit('save', 'save')->onClick[] = function (\Nette\Forms\Controls\SubmitButton $button) use ($form): void {
			/** @var \PeckaDesk\Dashboard\Issues\Forms\AddFormValues $values */
			$values = $form->getValues(\PeckaDesk\Dashboard\Issues\Forms\AddFormValues::class);
			$issue = $this->issueFacade->saveFromAddForm($this->project, $values);
			$this->flashMessage('saved', 'success');
			$this->redirect(':Dashboard:Issues:Edit:', [$issue]);
		};

		return $form;
	}

}
