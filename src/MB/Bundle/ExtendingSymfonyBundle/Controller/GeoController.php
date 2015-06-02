<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GeoController extends Controller
{
    public function indexAction()
    {
		$boundaries = $this->get('user_locator')->getUserGeoBoundaries();

		$em = $this->getDoctrine()->getManager();
		$qb = $em->createQueryBuilder();
		$qb->select('e')
			->from('MBExtendingSymfonyBundle:Event', 'e')
			->where('e.latitude < :lat_max')
			->andWhere('e.latitude > :lat_min')
			->andWhere('e.longitude < :long_max')
			->andWhere('e.longitude > :long_min')
			->setParameters($boundaries);

		$events = $qb->getQuery()->execute();

        return $this->render('MBExtendingSymfonyBundle:Geo:index.html.twig', array(
			'events' => $events,
		));
	}

}
