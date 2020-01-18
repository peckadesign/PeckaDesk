<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\PeckaNotesLogin\Login\Presenters;

final class OAuth2Presenter extends \Nette\Application\UI\Presenter
{

	private \PeckaDesk\Dashboard\PeckaNotesLogin\PeckaNotesProvider $authProvider;

	private \PeckaDesk\Dashboard\PeckaNotesLogin\StateStorage $stateStorage;

	private \PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade;

	private \PeckaDesk\Dashboard\Users\PersistentLoginFacadeInterface $persistentLoginFacade;


	public function __construct(
		\PeckaDesk\Dashboard\PeckaNotesLogin\PeckaNotesProvider $authProvider,
		\PeckaDesk\Dashboard\PeckaNotesLogin\StateStorage $stateStorage,
		\PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade,
		\PeckaDesk\Dashboard\Users\PersistentLoginFacadeInterface $persistentLoginFacade
	)
	{
		parent::__construct();
		$this->authProvider = $authProvider;
		$this->stateStorage = $stateStorage;
		$this->userFacade = $userFacade;
		$this->persistentLoginFacade = $persistentLoginFacade;
	}


	protected function startup()
	{
		parent::startup();

		$this->user->onLoggedIn[] = function (\Nette\Security\User $sender): void {
			$this->persistentLoginFacade->login($sender, $this->getHttpRequest());
		};
	}


	public function actionAuthorize(?string $code = NULL, ?string $state = NULL): void
	{
		if ( ! $this->stateStorage->validateState($state)) {
			$this->error('Požadavek není validní, zkuste se přihlásit znovu.', \Nette\Http\IResponse::S403_FORBIDDEN);
		}

		try {
			$accessToken = $this->authProvider->getAccessToken('authorization_code', [
				'code' => $code,
			]);

			/** @var \PeckaDesk\Dashboard\PeckaNotesLogin\User $peckanotesUser */
			$peckanotesUser = $this->authProvider->getResourceOwner($accessToken);

			try {
				$user = $this->userFacade->getByEmail($peckanotesUser->getId());
			} catch (\PeckaDesk\Dashboard\Model\EntityNotFoundException $e) {
				$user = new \PeckaDesk\Model\Users\User($peckanotesUser->getId(), $peckanotesUser->getFirstName(), $peckanotesUser->getLastName());
			}

			$user->setPeckanotesToken($accessToken);
			$this->userFacade->addUser($user);
			$this->user->login($user);
		} catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
			throw $e;
		}

		$this->restoreRequest($state);
		$this->redirect(':DashBoard:HomePage');
	}

}
