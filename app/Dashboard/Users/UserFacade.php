<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Users;

final class UserFacade implements UserFacadeInterface
{

	private \Doctrine\ORM\EntityManagerInterface $entityManager;


	public function __construct(
		\Doctrine\ORM\EntityManagerInterface $entityManager
	)
	{
		$this->entityManager = $entityManager;
	}


	public function addUser(\PeckaDesk\Model\Users\User $user): void
	{
		$this->entityManager->persist($user);
		$this->entityManager->flush();
	}


	public function getByEmail(string $email): \PeckaDesk\Model\Users\User
	{
		$repository = $this->entityManager->getRepository(\PeckaDesk\Model\Users\User::class);

		$user = $repository->findOneBy(['email' => $email]);

		if ( ! $user instanceof \PeckaDesk\Model\Users\User) {
			throw new \PeckaDesk\Dashboard\Model\EntityNotFoundException();
		}

		return $user;
	}

}
