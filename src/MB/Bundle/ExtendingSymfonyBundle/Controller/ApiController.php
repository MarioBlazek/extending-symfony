<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
	public function apiAction()
	{
		return new Response('The API works great!');
	}
}