<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Security;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;

class ApiCustomListener
{
	public function onKernelRequest($event)
	{
		// secure urls
		if ( strpos($event->getRequest()->getPathInfo(), '/api/') ) {
			return;
		}

		$cookie = $event->getRequest()->headers->get('cookie');
		$double = $event->getRequest()->headers->get('X-Doubled-Cookie');

		if ( $cookie !== $double ) {
			$event->setResponse(new Response('', 400));
		}
	}
}