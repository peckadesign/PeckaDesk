<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Presenters;

final class LoginPresenter extends \Nette\Application\UI\Presenter
{

	/**
	 * @persistent
	 */
	public ?string $backlink = NULL;

	private Forms\LoginFormFactory $loginFormFactory;

	private \PeckaDesk\Dashboard\PeckaNotesLogin\PeckaNotesProvider $authProvider;

	private \PeckaDesk\Dashboard\PeckaNotesLogin\StateStorage $stateStorage;


	public function __construct(
		\PeckaDesk\Dashboard\Presenters\Forms\LoginFormFactory $loginFormFactory,
		\PeckaDesk\Dashboard\PeckaNotesLogin\PeckaNotesProvider $authProvider,
		\PeckaDesk\Dashboard\PeckaNotesLogin\StateStorage $stateStorage
	)
	{
		parent::__construct();
		$this->loginFormFactory = $loginFormFactory;
		$this->authProvider = $authProvider;
		$this->stateStorage = $stateStorage;
	}


	public function createComponentForm(): \Nette\Application\UI\Form
	{
		$form = $this->loginFormFactory->create();

		$form->addSubmit('send', 'send')->onClick[] = function (\Nette\Forms\Controls\SubmitButton $button): void {
			$authorizationUrl = $this->authProvider->getAuthorizationUrl($this->backlink !== NULL ? ['state' => $this->backlink] : []);

			$this->stateStorage->saveState($this->authProvider->getState());

			$this->redirectUrl($authorizationUrl);
		};

		return $form;
	}

}
