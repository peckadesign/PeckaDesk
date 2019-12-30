<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Users;

final class Authenticator implements \Nette\Security\IAuthenticator
{

	/**
	 * @param array<mixed> $credentials
	 */
	public function authenticate(array $credentials): \Nette\Security\IIdentity
	{
		throw new \RuntimeException('Přihlašování jménem a heslem není možné');
	}

}
