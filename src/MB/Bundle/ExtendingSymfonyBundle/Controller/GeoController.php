<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Controller;

use MB\Bundle\ExtendingSymfonyBundle\Event\MeetupEvent;
use MB\Bundle\ExtendingSymfonyBundle\Event\MeetupEvents;
use MB\Bundle\ExtendingSymfonyBundle\Form\Type\JoinEventType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MB\Bundle\ExtendingSymfonyBundle\Security\Annotation\ValidateUser;

class GeoController extends Controller
{
    public function indexAction()
    {
		$boundaries = $this->get('mb.user_locator')->getUserGeoBoundaries();
		$em = $this->getDoctrine()->getManager();
		$qb = $em->createQueryBuilder();
		$qb->select('e')
			->from('MBExtendingSymfonyBundle:Event', 'e')
			->where('e.latitude < :lat_max')
			->andWhere('e.latitude > :lat_min')
			->andWhere('e.longitude < :long_max')
			->andWhere('e.longitude > :long_min')
			->setParameters($boundaries);

		$events = $qb->getQuery()->getResult();

        return $this->render('MBExtendingSymfonyBundle:Geo:index.html.twig', array(
			'events' => $events,
		));
	}

	/**
	 * @ValidateUser("join_event")
	 *
	 * @param $eventId
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function joinAction($eventId)
	{
		$reader = $this->get('annotation_reader');
		$method = new \ReflectionMethod(get_class($this), 'joinAction');
		$annotationName = 'MB\Bundle\ExtendingSymfonyBundle\Security\Annotation\ValidateUser';
		$annotation = $reader->getMethodAnnotation($method, $annotationName);

		$em = $this->getDoctrine()->getManager();
		$meetup = $em->getRepository('MBExtendingSymfonyBundle:Event')->find($eventId);

		$form = $this->createForm(new JoinEventType(), $meetup, array(
			'action' => '',
			'method' => 'POST'
		));

		$form->add('submit', 'submit', array('label' => 'Join'));

		$form->handleRequest($this->get('request'));

		$user = $this->get('security.context')->getToken()->getUser();

		if ( $form->isValid() ) {
			$meetup->addAttendee($user);
			$this->get('event_dispatcher')->dispatch(MeetupEvents::MEETUP_JOIN, new MeetupEvent($user, $meetup));
			$em->flush();
		}

		return $this->render('MBExtendingSymfonyBundle:Geo:index.html.twig', array(
			'meetup' => $meetup,
			'user'	 => $user,
			'form' 	 => $form->createView(),
		));
	}

}
