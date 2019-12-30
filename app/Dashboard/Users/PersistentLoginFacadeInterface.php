<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Users;

interface PersistentLoginFacadeInterface
{

	public function login(\Nette\Security\User $user, \Nette\Http\IRequest $request): void;


	public function tryAuthenticate(\Nette\Http\IRequest $request, \Nette\Security\User $user): void;

}
