<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Projects\Presenters;

final class AddPresenter extends \PeckaDesk\Dashboard\Presenters\BasePresenter
{

	private \PeckaDesk\Dashboard\Projects\Forms\AddFormFactory $formFactory;

	private \PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade;


	public function __construct(
		\PeckaDesk\Dashboard\Projects\Forms\AddFormFactory $formFactory,
		\PeckaDesk\Dashboard\Projects\Model\ProjectFacadeInterface $projectFacade
	)
	{
		$this->formFactory = $formFactory;
		$this->projectFacade = $projectFacade;
	}


	public function actionDefault(): void
	{
	}


	protected function createComponentForm(): \Nette\Application\UI\Form
	{
		$form = $this->formFactory->create();

		$form->addSubmit('save', 'save')->onClick[] = function (\Nette\Forms\Controls\SubmitButton $button) use ($form): void {
			/** @var \PeckaDesk\Dashboard\Projects\Forms\AddFormValues $values */
			$values = $form->getValues(\PeckaDesk\Dashboard\Projects\Forms\AddFormValues::class);
			$project = $this->projectFacade->saveFromAddForm($values);
			$this->flashMessage('saved', 'success');
			$this->redirect(':Dashboard:Projects:Detail:', $project);
		};

		return $form;
	}

}
