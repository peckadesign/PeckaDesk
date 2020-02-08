<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Projects\Forms;

final class AddUserFormFactory
{

	public const CONTROL_USER = 'user';
	public const CONTROL_ROLE = 'role';

	private \PeckaDesk\Dashboard\Forms\BaseFactory $baseFactory;

	private \PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade;


	public function __construct(
		\PeckaDesk\Dashboard\Forms\BaseFactory $baseFactory,
		\PeckaDesk\Dashboard\Users\Model\UserFacadeInterface $userFacade
	)
	{
		$this->baseFactory = $baseFactory;
		$this->userFacade = $userFacade;
	}


	public function create(): \Nette\Application\UI\Form
	{
		$form = $this->baseFactory->create();

		$users = $this->userFacade->fetchAll();
		$items = [];
		foreach ($users as $user) {
			$items[$user->getId()] = new UserForSelect($user);
		}

		$form
			->addSelect(self::CONTROL_USER, 'user', $items)
			->setRequired(TRUE)
		;

		$form
			->addSelect(self::CONTROL_ROLE, 'role', \PeckaDesk\Model\Users\User::$ROLES)
			->setRequired(TRUE)
		;

		return $form;
	}

}
