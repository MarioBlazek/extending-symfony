<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Security\Voters;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class MeetupVoter implements VoterInterface
{

	/**
	 * Checks if the voter supports the given attribute.
	 *
	 * @param string $attribute An attribute
	 *
	 * @return bool true if this Voter supports the attribute, false otherwise
	 */
	public function supportsAttribute($attribute)
	{
		return $attribute === 'EDIT';
	}

	/**
	 * Checks if the voter supports the given class.
	 *
	 * @param string $class A class name
	 *
	 * @return bool true if this Voter can process the class
	 */
	public function supportsClass($class)
	{
		return $class === 'MB\Bundle\ExtendingSymfonyBundle\Entity\Event';
	}

	/**
	 * Returns the vote for the given parameters.
	 *
	 * This method must return one of the following constants:
	 * ACCESS_GRANTED, ACCESS_DENIED, or ACCESS_ABSTAIN.
	 *
	 * @param TokenInterface $token A TokenInterface instance
	 * @param object|null $object The object to secure
	 * @param array $attributes An array of attributes associated with the method being invoked
	 *
	 * @return int either ACCESS_GRANTED, ACCESS_ABSTAIN, or ACCESS_DENIED
	 */
	public function vote(TokenInterface $token, $object, array $attributes)
	{
		if ( !$this->supportsAttribute($attributes[0]) || !$this->supportsClass(get_class($object)) ) {
			return VoterInterface::ACCESS_ABSTAIN;
		}

		if ( $this->meetupHasNoAttendes($object) && $this->isMeetupCreator($token->getUser(), $object) ) {
			return VoterInterface::ACCESS_GRANTED;
		}

		return VoterInterface::ACCESS_DENIED;
	}

	/**
	 * Check if meetup han no attendees
	 *
	 * @param $meetup
	 * @return bool
	 */
	protected function meetupHasNoAttendes($meetup)
	{
		return $meetup->getAttendes()->count() === 0;
	}

	/**
	 * Check if current user is meetup creator for given meetup
	 *
	 * @param $user
	 * @param $meetup
	 * @return bool
	 */
	protected function isMeetupCreator($user, $meetup)
	{
		return $user->getUserId() === $meetup->getUserId();
	}
}