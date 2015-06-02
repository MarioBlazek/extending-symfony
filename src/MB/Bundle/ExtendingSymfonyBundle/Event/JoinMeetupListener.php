<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Event;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class JoinMeetupListener implements EventSubscriberInterface
{
	protected $event;

	public function generatePreferences()
	{
		if ($this->event) {
			// generate new preferences for user
			// @TODO
		}
	}

	public function onUserJoinsMeetup(MeetupEvent $event)
	{
		$this->event = $event;
	}

	/**
	 * Returns an array of event names this subscriber wants to listen to.
	 *
	 * The array keys are event names and the value can be:
	 *
	 *  * The method name to call (priority defaults to 0)
	 *  * An array composed of the method name to call and the priority
	 *  * An array of arrays composed of the method names to call and respective
	 *    priorities, or 0 if unset
	 *
	 * For instance:
	 *
	 *  * array('eventName' => 'methodName')
	 *  * array('eventName' => array('methodName', $priority))
	 *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
	 *
	 * @return array The event names to listen to
	 *
	 * @api
	 */
	public static function getSubscribedEvents()
	{
		return [
			MeetupEvents::MEETUP_JOIN	=> 'onUserJoins',
			KernelEvents::TERMINATE		=> 'generatePreferences'
		];
	}
}