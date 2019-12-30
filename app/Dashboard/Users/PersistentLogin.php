<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Users;

/**
 * @\Doctrine\ORM\Mapping\Entity
 * @\Doctrine\ORM\Mapping\Table(name="persistentLogin")
 */
class PersistentLogin
{

	public const TOKEN_LENGTH = 32;

	/**
	 * @\Doctrine\ORM\Mapping\Id
	 * @\Doctrine\ORM\Mapping\ManyToOne(targetEntity="\PeckaDesk\Model\Users\User", inversedBy="persistentTokens")
	 */
	private \PeckaDesk\Model\Users\User $user;

	/**
	 * @\Doctrine\ORM\Mapping\Id
	 * @\Doctrine\ORM\Mapping\Column(type="string")
	 */
	private string $token;

	/** @\Doctrine\ORM\Mapping\Column(type="string") */
	private string $ip;


	public function __construct(\PeckaDesk\Model\Users\User $user, string $token, string $ip)
	{
		$this->user = $user;
		$this->token = $token;
		$this->ip = $ip;
	}


	public function getUser(): \PeckaDesk\Model\Users\User
	{
		return $this->user;
	}


	public function getToken(): string
	{
		return $this->token;
	}


	public function getIp(): string
	{
		return $this->ip;
	}

}
