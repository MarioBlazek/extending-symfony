<?php

namespace MB\Bundle\GithubAuthBundle\Tests\Security\Github;

use MB\Bundle\GithubAuthBundle\Security\Github\AuthenticationProvider;
use Mockery as m;

class AuthenticationProviderTest extends \PHPUnit_Framework_TestCase
{
	public function testAuthenticatesToken()
	{
		$user = m::mock( ['getName' => 'Testis', 'getRoles' => ['ROLE_ADMIN']]) ;
		$userProvider = m::mock(['loadOrCreateUser' => $user]);
		$unauthenticated_token = m::mock(
			'MB\Bundle\GithubAuthBundle\Security\Github\GithubUserToken',
			['getCredentials' => 'testis@example.com']);

		$authProvider = new AuthenticationProvider($userProvider);

		$token = $authProvider->authenticate($unauthenticated_token);

		$this->assertTrue($token->isAuthenticated());
		$this->assertEquals($token->getUser()->getName(),'Testis');
	}
}