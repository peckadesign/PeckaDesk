<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Projects\Forms;

final class UserForSelect
{

	private \PeckaDesk\Model\Users\User $user;


	public function __construct(\PeckaDesk\Model\Users\User $user)
	{
		$this->user = $user;
	}


	public function getUser(): \PeckaDesk\Model\Users\User
	{
		return $this->user;
	}


	public function __toString()
	{
		return $this->user->getFirstName() . ' ' . $this->user->getLastName();
	}

}
