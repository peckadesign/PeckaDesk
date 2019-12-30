<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Users;

interface UserFacadeInterface
{

	public function addUser(\PeckaDesk\Model\Users\User $user): void;


	public function getByEmail(string $email): \PeckaDesk\Model\Users\User;

}
