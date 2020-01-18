<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Users\Model;

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


	public function getById(int $id): \PeckaDesk\Model\Users\User
	{
		$repository = $this->entityManager->getRepository(\PeckaDesk\Model\Users\User::class);

		$user = $repository->find($id);

		if ( ! $user instanceof \PeckaDesk\Model\Users\User) {
			throw new \PeckaDesk\Dashboard\Model\EntityNotFoundException();
		}

		return $user;
	}


	public function queryFactory(): \Doctrine\ORM\QueryBuilder
	{
		$qb = $this->entityManager->createQueryBuilder();
		$qb->select('u')->from(\PeckaDesk\Model\Users\User::class, 'u');

		return $qb;
	}


	public function fetchAll(): array
	{
		$qb = $this->queryFactory();

		return $qb->getQuery()->getResult();
	}


	public function saveFromEditForm(\PeckaDesk\Model\Users\User $user, \PeckaDesk\Dashboard\Users\Forms\EditFormValues $editFormValues): void
	{
		$user->setEmail($editFormValues->email);
		$user->setFirstName($editFormValues->firstName);
		$user->setLastName($editFormValues->lastName);
		$this->entityManager->flush();
	}


	public function saveFromAddForm(\PeckaDesk\Dashboard\Users\Forms\AddFormValues $addFormValues): \PeckaDesk\Model\Users\User
	{
		$user = new \PeckaDesk\Model\Users\User($addFormValues->email, $addFormValues->firstName, $addFormValues->lastName);
		$this->entityManager->persist($user);
		$this->entityManager->flush();

		return $user;
	}

}
