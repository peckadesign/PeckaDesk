<?php declare(strict_types = 1);

namespace PeckaDesk\Model\Users;

/**
 * @\Doctrine\ORM\Mapping\Entity
 * @\Doctrine\ORM\Mapping\Table(name="user")
 */
class User implements \Nette\Security\IIdentity
{

	public const ROLE_ADMINISTRATOR = 'administrator';
	public const ROLE_SUPPORT = 'support';
	public const ROLE_CLIENT = 'client';
	public const ROLE_AUTHENTICATED = 'authenticated';

	public static $ROLES = [
		self::ROLE_ADMINISTRATOR => self::ROLE_ADMINISTRATOR,
		self::ROLE_SUPPORT => self::ROLE_SUPPORT,
		self::ROLE_CLIENT => self::ROLE_CLIENT,
	];

	/**
	 * @\Doctrine\ORM\Mapping\Id
	 * @\Doctrine\ORM\Mapping\Column(type="integer")
	 * @\Doctrine\ORM\Mapping\GeneratedValue
	 */
	private ?int $id = NULL;

	/**
	 * @\Doctrine\ORM\Mapping\Column(type="string")
	 */
	private string $email;

	/**
	 * @\Doctrine\ORM\Mapping\Column(type="string")
	 */
	private string $firstName;

	/**
	 * @\Doctrine\ORM\Mapping\Column(type="string")
	 */
	private string $lastName;

	/**
	 * @\Doctrine\ORM\Mapping\Column(type="string", nullable=TRUE)
	 */
	private ?string $peckanotesToken = NULL;

	/**
	 * @\Doctrine\ORM\Mapping\OneToMany(targetEntity="\PeckaDesk\Dashboard\Users\PersistentLogin", mappedBy="user", cascade={"ALL"}, indexBy="token")
	 */
	private \Doctrine\Common\Collections\Collection $persistentTokens;

	/**
	 * @\Doctrine\ORM\Mapping\OneToMany(targetEntity="\PeckaDesk\Model\UsersOnProjects\UserOnProject", mappedBy="user", cascade={"ALL"}, indexBy="project")
	 */
	private \Doctrine\Common\Collections\Collection $allowedProjects;

	/**
	 * @\Doctrine\ORM\Mapping\Column(type="boolean")
	 */
	private bool $administrator = FALSE;


	public function __construct(
		string $email,
		string $firstName,
		string $lastName
	)
	{
		$this->email = $email;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->persistentTokens = new \Doctrine\Common\Collections\ArrayCollection();
		$this->allowedProjects = new \Doctrine\Common\Collections\ArrayCollection();
	}


	public function getId(): int
	{
		return $this->id;
	}


	public function getEmail(): string
	{
		return $this->email;
	}


	public function setEmail(string $email): void
	{
		$this->email = $email;
	}


	public function getFirstName(): string
	{
		return $this->firstName;
	}


	public function setFirstName(string $firstName): void
	{
		$this->firstName = $firstName;
	}


	public function getLastName(): string
	{
		return $this->lastName;
	}


	public function setLastName(string $lastName): void
	{
		$this->lastName = $lastName;
	}


	public function getPeckanotesToken(): ?\League\OAuth2\Client\Token\AccessToken
	{
		return $this->peckanotesToken !== NULL ? new \League\OAuth2\Client\Token\AccessToken(\Nette\Utils\Json::decode($this->peckanotesToken)) : NULL;
	}


	public function setPeckanotesToken(?\League\OAuth2\Client\Token\AccessTokenInterface $accessToken): void
	{
		$this->peckanotesToken = $accessToken !== NULL ? \Nette\Utils\Json::encode($accessToken) : NULL;
	}


	/**
	 * @return array<string>
	 */
	public function getRoles(): array
	{
		static $roles = NULL;

		if ($roles === NULL) {
			$cb = function (\PeckaDesk\Model\UsersOnProjects\UserOnProject $userOnProject): string {
				return $userOnProject->getRoleId();
			};

			$roles = $this->allowedProjects->map($cb)->toArray();

			if ($this->isAdministrator()) {
				$roles = \array_merge($roles, [self::ROLE_ADMINISTRATOR]);
			}

			$roles = \array_merge($roles, [self::ROLE_AUTHENTICATED]);
		}

		return $roles;
	}


	public function isAdministrator(): bool
	{
		return $this->administrator;
	}


	public function setAdministrator(bool $administrator): void
	{
		$this->administrator = $administrator;
	}

}
