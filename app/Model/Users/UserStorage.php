<?php declare(strict_types = 1);

namespace PeckaDesk\Model\Users;

final class UserStorage extends \Nette\Http\UserStorage
{

	private \Doctrine\ORM\EntityManagerInterface $entityManager;


	public function __construct(
		\Nette\Http\Session $sessionHandler,
		\Doctrine\ORM\EntityManagerInterface $entityManager
	)
	{
		parent::__construct($sessionHandler);
		$this->entityManager = $entityManager;
	}


	public function setIdentity(?\Nette\Security\IIdentity $identity): \Nette\Security\IUserStorage
	{
		if ($identity !== NULL) {
			$identity = new class($identity->getId()) implements \Nette\Security\IIdentity {

				/**
				 * @var int
				 */
				private int $id;


				public function __construct(int $id)
				{
					$this->id = $id;
				}


				function getId(): int
				{
					return $this->id;
				}


				function getRoles(): array
				{
					return [];
				}
			};
		}

		return parent::setIdentity($identity);
	}


	public function getIdentity(): ?\Nette\Security\IIdentity
	{
		$identity = parent::getIdentity();

		return $this->entityManager->find(User::class, $identity->getId());
	}

}
