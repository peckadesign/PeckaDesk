<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Users\Forms;

final class EditFormValues
{

	public string $email;

	public string $firstName;

	public string $lastName;

	public bool $administrator;


	public static function createFromUser(\PeckaDesk\Model\Users\User $User): self
	{
		$return = new self();

		$return->email = $User->getEmail();
		$return->firstName = $User->getFirstName();
		$return->lastName = $User->getLastName();
		$return->administrator = $User->isAdministrator();

		return $return;
	}

}
