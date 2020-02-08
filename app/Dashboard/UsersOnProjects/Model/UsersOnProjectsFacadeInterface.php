<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\UsersOnProjects\Model;

interface UsersOnProjectsFacadeInterface
{

	public function fetchUsersOnProject(\PeckaDesk\Model\Projects\Project $project): array;


	public function fetchUsersProjects(\PeckaDesk\Model\Users\User $user): array;


	public function queryFactory(): \Doctrine\ORM\QueryBuilder;


	public function fetchUsersOnProjectQuery(\PeckaDesk\Model\Projects\Project $project): \Doctrine\ORM\QueryBuilder;


	/**
	 * @return array<\PeckaDesk\Model\UsersOnProjects\UserOnProject>
	 */
	public function fetchAll(): array;

}
