<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Projects\Forms;

final class EditFormFactory
{

	public const CONTROL_NAME = 'name';

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

		return $form;
	}

}
