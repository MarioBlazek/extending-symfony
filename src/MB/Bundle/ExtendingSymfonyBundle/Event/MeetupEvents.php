<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Event;


final class MeetupEvents
{
	/**
	 * The meetup.join event is triggered every time a user
	 * registers for a meetup.
	 *
	 * Listeners receive an instance of:
	 * MB\Bundle\ExtendingSymfonyBundle\Event\MeetupEvent
	 */
	const MEETUP_JOIN = 'meetup.join';
}