<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Users\Model;

interface UserFacadeInterface
{

	public function addUser(\PeckaDesk\Model\Users\User $user): void;


	public function getByEmail(string $email): \PeckaDesk\Model\Users\User;


	public function getById(int $id): \PeckaDesk\Model\Users\User;


	public function queryFactory(): \Doctrine\ORM\QueryBuilder;


	/**
	 * @return array<\PeckaDesk\Model\Users\User>
	 */
	public function fetchAll(): array;


	public function saveFromEditForm(\PeckaDesk\Model\Users\User $user, \PeckaDesk\Dashboard\Users\Forms\EditFormValues $editFormValues): void;


	public function saveFromAddForm(\PeckaDesk\Dashboard\Users\Forms\AddFormValues $addFormValues): \PeckaDesk\Model\Users\User;


	public function fetchAdministrators(): array;
}
