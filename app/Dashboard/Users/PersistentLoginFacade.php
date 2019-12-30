<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Users;

final class PersistentLoginFacade implements PersistentLoginFacadeInterface
{

	private \Doctrine\ORM\EntityManagerInterface $entityManager;

	/**
	 * @var \Nette\Http\IResponse
	 */
	private \Nette\Http\IResponse $response;


	public function __construct(
		\Doctrine\ORM\EntityManagerInterface $entityManager,
		\Nette\Http\IResponse $response
	)
	{
		$this->entityManager = $entityManager;
		$this->response = $response;
	}


	public function login(\Nette\Security\User $user, \Nette\Http\IRequest $request): void
	{
		$ip = $request->getRemoteAddress();
		if ($ip === NULL) {
			return;
		}

		$identity = $user->getIdentity();
		if ( ! $identity instanceof \PeckaDesk\Model\Users\User) {
			return;
		}

		$token = \Nette\Utils\Random::generate(PersistentLogin::TOKEN_LENGTH);

		$login = new PersistentLogin($identity, $token, $ip);

		$this->entityManager->persist($login);
		$this->entityManager->flush();

		$this->response->setCookie('persistentLogin', $token, '+ 1 year');
	}


	public function tryAuthenticate(\Nette\Http\IRequest $request, \Nette\Security\User $user): void
	{
		$cookie = $request->getCookie('persistentLogin');
		if ($cookie === NULL) {
			return;
		}

		/** @var \Doctrine\ORM\EntityRepository $repository */
		$repository = $this->entityManager->getRepository(PersistentLogin::class);

		/** @var PersistentLogin|null $persistentLogin */
		$persistentLogin = $repository->findOneBy(['token' => $cookie]);

		if ($persistentLogin === NULL) {
			return;
		}

		$user->login($persistentLogin->getUser());
	}

}
