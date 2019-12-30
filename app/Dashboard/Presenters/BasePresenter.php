<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Presenters;

/**
 * @property-read \Nette\Bridges\ApplicationLatte\Template $template
 */
abstract class BasePresenter extends \Nette\Application\UI\Presenter
{

	private \PeckaDesk\Dashboard\Navigation\Factory $navigationFactory;

	private \PeckaDesk\Dashboard\Users\PersistentLoginFacadeInterface $persistentLoginFacade;


	public function injectNavigationFactory(\PeckaDesk\Dashboard\Navigation\Factory $navigationFactory): void
	{
		$this->navigationFactory = $navigationFactory;
	}


	public function injectPersistentLoginFacade(\PeckaDesk\Dashboard\Users\PersistentLoginFacadeInterface $persistentLoginFacade): void
	{
		$this->persistentLoginFacade = $persistentLoginFacade;
	}


	protected function startup()
	{
		parent::startup();

		if ( ! $this->user->isLoggedIn()) {
			$this->persistentLoginFacade->tryAuthenticate($this->getHttpRequest(), $this->user);
		}

		if ( ! $this->user->isLoggedIn()) {
			$this->redirect(':Dashboard:Login:default', ['backlink' => $this->storeRequest()]);
		}
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

		$title = $navigation->getSelected()->getLabel();

		$this
			->template
			->add('menu', $navigation->getChild(':Dashboard:Projects:List:default'))
			->add('breadcrumb', $breadcrumb)
			->add('title', $title)
		;
	}


	public function handleLogout(): void
	{
		$this->user->logout();
		$this->redirect('this');
	}

}
