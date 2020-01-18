<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Users\Forms;

final class AddFormFactory
{

	public const CONTROL_EMAIL = 'email';
	public const CONTROL_FIRST_NAME = 'firstName';
	public const CONTROL_LAST_NAME = 'lastName';

	private \PeckaDesk\Dashboard\Forms\BaseFactory $baseFactory;


	public function __construct(\PeckaDesk\Dashboard\Forms\BaseFactory $baseFactory)
	{
		$this->baseFactory = $baseFactory;
	}


	public function create(): \Nette\Application\UI\Form
	{
		$form = $this->baseFactory->create();

		$form
			->addText(self::CONTROL_EMAIL, 'email', NULL, 255)
			->setHtmlType('email')
			->setRequired(TRUE)
		;

		$form
			->addText(self::CONTROL_FIRST_NAME, 'firstName', NULL, 255)
			->setRequired(TRUE)
		;

		$form
			->addText(self::CONTROL_LAST_NAME, 'lastName', NULL, 255)
			->setRequired(TRUE)
		;

		return $form;
	}

}
