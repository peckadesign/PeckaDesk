<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Forms;

final class BaseFactory
{

	private \Nette\Localization\ITranslator $translator;


	public function __construct(
		\Nette\Localization\ITranslator $translator
	)
	{
		$this->translator = $translator;
	}


	public function create(): \Nette\Application\UI\Form
	{
		$form = new \Nette\Application\UI\Form();

		$form->setTranslator($this->translator);

		return $form;
	}

}
