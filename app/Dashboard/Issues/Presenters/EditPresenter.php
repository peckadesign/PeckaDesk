<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Presenters;

final class EditPresenter extends \PeckaDesk\Dashboard\Presenters\BasePresenter
{

	private \PeckaDesk\Dashboard\Issues\Forms\EditFormFactory $formFactory;

	private \PeckaDesk\Model\Issues\Issue $issue;

	private \PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade;


	public function __construct(
		\PeckaDesk\Dashboard\Issues\Forms\EditFormFactory $formFactory,
		\PeckaDesk\Dashboard\Issues\Model\IssueFacadeInterface $issueFacade
	)
	{
		parent::__construct();
		$this->formFactory = $formFactory;
		$this->issueFacade = $issueFacade;
	}


	public function actionDefault(\PeckaDesk\Model\Issues\Issue $issue): void
	{
		$this->issue = $issue;

		$this['form']->setDefaults(\PeckaDesk\Dashboard\Issues\Forms\EditFormValues::createFromIssue($this->issue));
	}


	protected function createComponentForm(): \Nette\Application\UI\Form
	{
		$form = $this->formFactory->create();

		$form->addSubmit('save', 'save')->onClick[] = function (\Nette\Forms\Controls\SubmitButton $button) use ($form): void {
			/** @var \PeckaDesk\Dashboard\Issues\Forms\EditFormValues $values */
			$values = $form->getValues(\PeckaDesk\Dashboard\Issues\Forms\EditFormValues::class);
			$this->issueFacade->saveFromEditForm($this->issue, $values);
			$this->flashMessage('saved', 'success');
			$this->redirect('this');
		};

		return $form;
	}

}
