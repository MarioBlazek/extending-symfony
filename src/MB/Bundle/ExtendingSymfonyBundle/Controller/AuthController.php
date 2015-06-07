<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Controller;

use Guzzle\Http\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
	public function githubLoginAction(Request $request)
	{
		$client = new Client('https://github.com/login/oauth/access_token');
		$req = $client->post('', null, [
			'client_id' 	=> $this->container->getParameter('github_client_id'),
			'client_secret' => $this->container->getParameter('github_client_secret'),
			'code'			=> $request->query->get('code'),
		])->setHeader('Accept', 'application/json');

		$res = $req->send()->json();
		var_dump($res);
		$token = $res['access_token'];

		$client = new Client('https://api.github.com');
		$req = $client->get('/user');
		$req->getQuery()->set('access_token', $token);
		$username = $req->send()->json()['login'];

		return new Response($username);
	}
}