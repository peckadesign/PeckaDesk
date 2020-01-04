<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Forms;

final class AddFormFactory
{

	public const CONTROL_NAME = 'name';
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

		$form
			->addText(self::CONTROL_NAME, 'name', NULL, 255)
			->setRequired(TRUE)
		;

		$form
			->addTextArea(self::CONTROL_DESCRIPTION, 'description')
			->setRequired(FALSE)
		;

		$form
			->addMultiUpload(self::CONTROL_FILES, 'files')
			->setRequired(FALSE)
		;

		return $form;
	}

}
