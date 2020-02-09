<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Users\Presenters;

final class DetailPresenter extends \PeckaDesk\Dashboard\Presenters\BasePresenter
{

	private \PeckaDesk\Model\Users\User $editedUser;

	private \PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade;


	public function __construct(
		\PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade
	)
	{
		parent::__construct();
		$this->userFacade = $userFacade;
	}


	public function actionDefault(\PeckaDesk\Model\Users\User $user): void
	{
		if ( ! $this->getUser()->isAllowed(\PeckaDesk\Dashboard\Users\AclFactory::RESOURCE_USERS, \PeckaDesk\Dashboard\Users\AclFactory::PERMISSION_READ)) {
			throw new \Nette\Application\ForbiddenRequestException();
		}

		$this->editedUser = $user;
	}


	public function renderDefault(): void
	{
		$this
			->template
			->add('editedUser', $this->editedUser);
	}

}
