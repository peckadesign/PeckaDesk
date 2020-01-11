<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Issues\Forms;

final class DescriptionControlFactory
{

	public static function create(): \Nette\Forms\Controls\TextArea
	{
		$control = new \Nette\Forms\Controls\TextArea('description');
		$control->setRequired(FALSE);

		return $control;
	}

}
