<?php

namespace MB\Bundle\GithubAuthBundle\Security\Github;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthenticationProvider implements AuthenticationProviderInterface
{
	private $userProvider;

	public function __construct($userProvider)
	{
		$this->userProvider = $userProvider;
	}

	/**
	 * Attempts to authenticate a TokenInterface object.
	 *
	 * @param TokenInterface $token The TokenInterface instance to authenticate
	 *
	 * @return TokenInterface An authenticated TokenInterface instance, never null
	 *
	 * @throws AuthenticationException if the authentication fails
	 */
	public function authenticate(TokenInterface $token)
	{
		$email = $token->getCredentials();
		$user = $this->userProvider->loadOrCreate($email);

		// log the user in
		$newToken = new GithubUserToken($user->getRoles);
		$newToken->setUser($user);
		$newToken->setAuthenticated(true);

		return $newToken;
	}

	/**
	 * Checks whether this provider supports the given token.
	 *
	 * @param TokenInterface $token A TokenInterface instance
	 *
	 * @return bool true if the implementation supports the Token, false otherwise
	 */
	public function supports(TokenInterface $token)
	{
		return $token instanceof GithubUserToken;
	}
}