<?php

namespace MB\Bundle\GithubAuthBundle\Security\Github;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class GithubUserToken extends AbstractToken
{
	private $credentials;

	/**
	 * Set credentials
	 *
	 * @param $email
	 */
	public function setCredentials($email)
	{
		$this->credentials = $email;
	}

	/**
	 * Returns the user credentials.
	 *
	 * @return mixed The user credentials
	 */
	public function getCredentials()
	{
		return $this->credentials;
	}
}