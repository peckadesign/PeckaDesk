<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Forms;

final class ReplyFormFactory
{

	public const CONTROL_DESCRIPTION = 'description';
	public const CONTROL_FILES = 'files';

	private \PeckaDesk\Dashboard\Forms\BaseFactory $baseFactory;


	public function __construct(\PeckaDesk\Dashboard\Forms\BaseFactory $baseFactory)
	{
		$this->baseFactory = $baseFactory;
	}


	public function create(): \Nette\Application\UI\Form
	{
		$form = $this->baseFactory->create();

		$control = DescriptionControlFactory::create();
		$form->addComponent($control, self::CONTROL_DESCRIPTION);

		$form
			->addMultiUpload(self::CONTROL_FILES, 'files')
			->setRequired(FALSE)
		;

		return $form;
	}

}
