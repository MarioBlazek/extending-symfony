<?php

namespace MB\Bundle\GithubAuthBundle\Security\Github;

use Guzzle\Http\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;

class AuthenticationListener extends AbstractAuthenticationListener
{
	protected $clientId;

	protected $clientSecret;

	public function setSecurityParameters($clientId, $clientSecret)
	{
		$this->clientId = $clientId;
		$this->clientSecret = $clientSecret;
	}
	/**
	 * Performs authentication.
	 *
	 * @param Request $request A Request instance
	 *
	 * @return TokenInterface|Response|null The authenticated token, null if full authentication is not possible, or a Response
	 *
	 * @throws AuthenticationException if the authentication fails
	 */
	protected function attemptAuthentication(Request $request)
	{
		$client = new Client(
			'https://github.com/login/oauth/access_token');

		$req = $client->post('', null, [
			'client_id' => $this->clientId,
			'client_secret' => $this->clientSecret,
			'code' => $request->query->get('code'),
		])->setHeader('Accept', 'application/json');

		$res = $req->send()->json();
		$access_token = $res['access_token'];

		$client = new Client('https://api.github.com');

		$req = $client->get('/user');
		$req->getQuery()->set('access_token', $access_token);

		$res = $req->send()->json();
		$email = $res['email'];

		$token = new GithubUserToken();
		$token->setCredentials($email);

        return $this->authenticationManager->authenticate($token);
	}
}