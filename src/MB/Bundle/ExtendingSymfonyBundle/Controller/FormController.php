<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Controller;

use MB\Bundle\ExtendingSymfonyBundle\Geo\Coordinate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FormController extends Controller
{
	public function mapAction(Request $request)
	{
		$location = new Coordinate();
		$form = $this->createFormBuilder()
			->add('location', 'mb_coordinate')
			->getForm();

		if ( $request->getMethod() == 'POST' ) {
			$form->handleRequest($request);

			$location = $form->getData()['location'];
		}

		$form = $form->createView();

		return $this->render('MBExtendingSymfonyBundle:Form:map.html.twig', [
			'form' 		=> $form,
			'location' 	=> $location,
		]);
	}
}