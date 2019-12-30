<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\PeckaNotesLogin;

final class User implements \League\OAuth2\Client\Provider\ResourceOwnerInterface
{

	/**
	 * @var array<mixed>
	 */
	private array $response;


	/**
	 * @param array<mixed> $response
	 */
	public function __construct(array $response)
	{

		$this->response = $response;
	}


	public function getId(): string
	{
		return $this->response['email'];
	}


	public function getFirstName(): string
	{
		return $this->response['firstName'];
	}


	public function getLastName(): string
	{
		return $this->response['lastName'];
	}


	public function isActive(): bool
	{
		return (bool) $this->response['active'];
	}


	/**
	 * @return array<mixed>
	 */
	public function toArray(): array
	{
		return $this->response;
	}

}
