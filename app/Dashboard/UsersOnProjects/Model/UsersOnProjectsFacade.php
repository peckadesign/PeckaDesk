<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\UsersOnProjects\Model;

final class UsersOnProjectsFacade implements UsersOnProjectsFacadeInterface
{

	private \Doctrine\ORM\EntityManagerInterface $entityManager;


	public function __construct(
		\Doctrine\ORM\EntityManagerInterface $entityManager
	)
	{
		$this->entityManager = $entityManager;
	}


	public function fetchUsersOnProject(\PeckaDesk\Model\Projects\Project $project): array
	{
		return $this->fetchUsersOnProjectQuery($project)->getQuery()->getResult();
	}


	public function fetchUsersProjects(\PeckaDesk\Model\Users\User $user): array
	{
		$qb = $this->queryFactory();

		$qb->where('uop.user = ?1');
		$qb->setParameter(1, $user);

		return $qb;
	}


	public function fetchUsersOnProjectQuery(\PeckaDesk\Model\Projects\Project $project): \Doctrine\ORM\QueryBuilder
	{
		$qb = $this->queryFactory();

		$qb->where('uop.project = ?1');
		$qb->setParameter(1, $project);

		return $qb;
	}


	public function queryFactory(): \Doctrine\ORM\QueryBuilder
	{
		$qb = $this->entityManager->createQueryBuilder();
		$qb->select('uop')->from(\PeckaDesk\Model\UsersOnProjects\UserOnProject::class, 'uop');

		return $qb;
	}


	public function fetchAll(): array
	{
		$qb = $this->queryFactory();

		return $qb->getQuery()->getResult();
	}

}
