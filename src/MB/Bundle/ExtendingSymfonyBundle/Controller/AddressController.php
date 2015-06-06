<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Controller;

use MB\Bundle\ExtendingSymfonyBundle\Entity\Address;
use MB\Bundle\ExtendingSymfonyBundle\Form\Type\AddressType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AddressController extends Controller
{
	public function addressAction(Request $request)
	{
		$message = '';
		$form = null;

		$address = new Address();

		if ( $request->getMethod() === 'GET' ) {
			$country = $this->get('mb.user_locator')
				->getCountryCode();

			$address->setCountry($country);
		}

		$form = $this->createForm(new AddressType(), $address, [
			'action' => '',
			'method' => 'POST',
		]);

		if ( $request->getMethod() === 'POST' ) {
			$form->handleRequest($request);

			if ( $form->isValid() ) {
				$message = 'This form is valid';
			}
		}

		$form = $form->createView();

		return $this->render('MBExtendingSymfonyBundle:Address:index.html.twig', [
			'form' 		=> $form,
			'message' 	=> $message,
		]);
	}
}