<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DoctrineController extends Controller
{
	public function indexAction()
	{
		$position = $this->get('mb.user_locator')->getUserCoordinates();
		$position = [
			'latitude' => $position->getLatitude(),
			'longitude' => $position->getLongitude(),
		];

		$em = $this->getDoctrine()->getManager();

		$qb = $em->createQueryBuilder();
		$qb->select('e')
			->from('MBExtendingSymfonyBundle:Event', 'e')
			->where('DISTANCE ((e.latitude, e.longitude), (:latitude, :longitude)) < 0.3')
			->setParameters($position);

		$events = $qb->getQuery()->execute();

		return $this->render('MBExtendingSymfonyBundle:Doctrine:index.html.twig', [
			'events' => $events,
		]);
	}
}