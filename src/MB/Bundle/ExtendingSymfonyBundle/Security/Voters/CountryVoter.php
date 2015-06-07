<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Security\Voters;

use MB\Bundle\ExtendingSymfonyBundle\Geo\UserLocator;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class CountryVoter implements VoterInterface
{
	protected $countryCode;

	public function __construct(Container $container)
	{
		$this->countryCode = $container->get('mb.user_locator')->getCountryCode();
	}
	/**
	 * Checks if the voter supports the given attribute.
	 *
	 * @param string $attribute An attribute
	 *
	 * @return bool true if this Voter supports the attribute, false otherwise
	 */
	public function supportsAttribute($attribute)
	{
		return $attribute === 'MEETUP_CREATE';
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
		return true;
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
		if ( !$this->supportsClass(get_class($object)) || !$this->supportsAttribute($attributes[0]) ) {
			return VoterInterface::ACCESS_ABSTAIN;
		}

		if ( $this->countryCode == 'CN' ) {
			return VoterInterface::ACCESS_GRANTED;
		}

		return VoterInterface::ACCESS_DENIED;
	}
}