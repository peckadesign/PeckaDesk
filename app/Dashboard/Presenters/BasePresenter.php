<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Presenters;

/**
 * @property-read \Nette\Bridges\ApplicationLatte\Template $template
 */
abstract class BasePresenter extends \Nette\Application\UI\Presenter
{

	private \PeckaDesk\Dashboard\Navigation\Factory $navigationFactory;


	public function injectNavigationFactory(\PeckaDesk\Dashboard\Navigation\Factory $navigationFactory): void
	{
		$this->navigationFactory = $navigationFactory;
	}


	/**
	 * @return array<string>
	 */
	public function formatLayoutTemplateFiles(): array
	{
		$layouts = parent::formatLayoutTemplateFiles();

		\array_unshift($layouts, __DIR__ . '/templates/@layout.latte');

		return $layouts;
	}


	protected function beforeRender()
	{
		parent::beforeRender();

		$navigation = $this->navigationFactory->create($this);

		$selected = $navigation->getSelected();
		$breadcrumb = [];
		while ($selected->getParent()) {
			\array_unshift($breadcrumb, $selected);
			$selected = $selected->getParent();
		}

		$this
			->template
			->add('menu', $navigation->getChild(':Dashboard:Projects:List:default'))
			->add('breadcrumb', $breadcrumb)
		;
	}

}
