<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Security;

use Doctrine\Common\Annotations\Reader;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Validator\Validator;

class ValidUserListener
{
	/**
	 * @var Reader
	 */
	private $reader;
	/**
	 * @var Router
	 */
	private $router;
	/**
	 * @var Session
	 */
	private $session;
	/**
	 * @var SecurityContext
	 */
	private $securityContext;
	/**
	 * @var Validator
	 */
	private $validator;

	private $annotationName = 'MB\Bundle\ExtendingSymfonyBundle\Security\Annotation\ValidateUser';

	public function __construct(Reader $reader, Router $router, Session $session,
								SecurityContext $securityContext, Validator $validator)
	{

		$this->reader = $reader;
		$this->router = $router;
		$this->session = $session;
		$this->securityContext = $securityContext;
		$this->validator = $validator;
	}

	public function onKernelController($event)
	{
		$className = get_class($event->getController()[0]);
		$methodName = $event->getController()[1];

		$method = new \ReflectionMethod($className, $methodName);

		// read the annotation
		$annotation = $this->reader->getMethodAnnotation($method, $this->annotationName);

		// if our controller does not have "ValidateUser"
		// annotation we do not do anything
		if ( !is_null($annotation) ) {
			// retrive the validation group from
			// the annotation
			// and try to validate the use
			$validationGroup = $annotation->getValidationGroup();
			$user = $this->securityContext->getToken()->getUser();
			$errors = $this->validator->validate($user, $validationGroup);

			if ( count($errors) ) {
				// if the user is not valid
				// change th controller
				// to redirect the user
				$event->setController(function ()
				{
					$this->session->getFlashBag()->add('warning', 'You must fill in your phone number
						before joining a meetup.');

					$url = $this->router->generate('fos_user_profile_edit');

					return new RedirectResponse($url);
				});
			}
		}
	}
}