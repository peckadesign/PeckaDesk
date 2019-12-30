<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Presenters\Forms;

final class LoginFormFactory
{

	public const CONTROL_EMAIL = 'email';

	private \PeckaDesk\Dashboard\Forms\BaseFactory $baseFactory;


	public function __construct(
		\PeckaDesk\Dashboard\Forms\BaseFactory $baseFactory
	)
	{
		$this->baseFactory = $baseFactory;
	}


	public function create(): \Nette\Application\UI\Form
	{
		$form = $this->baseFactory->create();

		$form
			->addEmail(self::CONTROL_EMAIL, 'email')
			->setRequired(TRUE)
		;

		return $form;
	}

}
