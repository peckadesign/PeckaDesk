<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Projects\Presenters;

final class EditPresenter extends \PeckaDesk\Dashboard\Presenters\BasePresenter
{

	private \PeckaDesk\Dashboard\Projects\Forms\EditFormFactory $formFactory;

	private \PeckaDesk\Model\Projects\Project $project;

	private \PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade;


	public function __construct(
		\PeckaDesk\Dashboard\Projects\Forms\EditFormFactory $formFactory,
		\PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade
	)
	{
		$this->formFactory = $formFactory;
		$this->projectFacade = $projectFacade;
	}


	public function actionDefault(\PeckaDesk\Model\Projects\Project $project): void
	{
		$this->project = $project;

		$form = $this['form'];
		if ( ! $form instanceof \Nette\Application\UI\Form) {
			throw new \RuntimeException();
		}
		$form->setDefaults(\PeckaDesk\Dashboard\Projects\Forms\EditFormValues::createFromProject($this->project));
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

}
