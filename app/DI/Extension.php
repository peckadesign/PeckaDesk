<?php declare(strict_types = 1);

namespace PeckaDesk\DI;

class Extension extends \Nette\DI\CompilerExtension
{

	public function beforeCompile()
	{
		parent::beforeCompile();
		$builder = $this->getContainerBuilder();

		/** @var \Nette\DI\Definitions\ServiceDefinition $application */
		$application = $builder->getDefinition($builder->getByType(\Nette\Application\UI\ITemplateFactory::class));
		$application->addSetup('?->onCreate[] = fn(\Nette\Bridges\ApplicationLatte\Template $template) => $template->setTranslator(?)', ['@self', $builder->getDefinition($builder->getByType(\PeckaDesk\Dashboard\Translator::class))]);
	}

}
