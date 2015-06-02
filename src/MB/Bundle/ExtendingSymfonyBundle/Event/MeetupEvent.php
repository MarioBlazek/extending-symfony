<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use MB\Bundle\ExtendingSymfonyBundle\Entity\Event as Meetup;
use MB\Bundle\ExtendingSymfonyBundle\Entity\User;

class MeetupEvent extends Event
{
	/**
	 * @var User
	 */
	private $user;
	/**
	 * @var Meetup
	 */
	private $meetup;

	public function __construct(User $user, Meetup $meetup)
	{
		$this->user = $user;
		$this->meetup = $meetup;
	}

	public function getUser()
	{
		return $this->user;
	}

	public function getMeetup()
	{
		return $this->meetup;
	}
}