<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\PeckaNotesLogin;

/**
 * @method User getResourceOwner(\League\OAuth2\Client\Token\AccessTokenInterface $token)
 */
final class PeckaNotesProvider extends \League\OAuth2\Client\Provider\GenericProvider
{

	/**
	 * @param array<mixed> $response
	 */
	protected function createResourceOwner(array $response, \League\OAuth2\Client\Token\AccessToken $token): User
	{
		return new User($response);
	}

}
