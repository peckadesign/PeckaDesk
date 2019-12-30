<?php declare(strict_types = 1);

namespace PeckaDesk\Model\Users;

/**
 * @\Doctrine\ORM\Mapping\Entity
 * @\Doctrine\ORM\Mapping\Table(name="user")
 */
class User implements \Nette\Security\IIdentity
{

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
	private ?string $peckanotesToken;

	/**
	 * @\Doctrine\ORM\Mapping\OneToMany(targetEntity="\PeckaDesk\Dashboard\Users\PersistentLogin", mappedBy="user", cascade={"ALL"}, indexBy="token")
	 */
	private \Doctrine\Common\Collections\Collection $persistentTokens;


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
		return $this->peckanotesToken ? new \League\OAuth2\Client\Token\AccessToken(\Nette\Utils\Json::decode($this->peckanotesToken)) : NULL;
	}


	public function setPeckanotesToken(?\League\OAuth2\Client\Token\AccessTokenInterface $accessToken): void
	{
		$this->peckanotesToken = $accessToken ? \Nette\Utils\Json::encode($accessToken) : NULL;
	}


	/**
	 * @return array<string>
	 */
	public function getRoles(): array
	{
		return [];
	}

}
