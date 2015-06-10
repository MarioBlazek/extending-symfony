<?php

namespace MB\Bundle\GithubAuthBundle\Security\Github;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
	protected $userManager;

	public function __construct($userManager)
	{
		$this->userManager = $userManager;
	}

	public function supportsClass($class)
	{
		return $this->userManager->supportsClass($class);
	}

	public function loadUserByUsername($email)
	{
		$user = $this->userManager->findUserByEmail($email);

		if (empty($user)) {
			if(empty($user)){
				$user = $this->userManager->createUser();
				$user->setEnabled(true);
				$user->setPassword('');
				$user->setEmail($email);
				$user->setUsername($email);
			}
			$this->userManager->updateUser($user);
		}

		if (empty($user)) {
			throw new UsernameNotFoundException('The user is not authenticated on github');
		}

		return $user;
	}

	public function loadOrCreateUser($email)
	{
		return $this->loadUserByUsername($email);
	}

	public function refreshUser(UserInterface $user)
	{
		if (!$this->supportsClass(get_class($user)) || !$user->getEmail()) {
			throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
		}

		return $this->loadUserByUsername($user->getEmail());
	}
}