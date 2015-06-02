<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Geo;

/**
 * Class RandomLocationGeocoder
 * Used only for examples
 * Returns some random coordinates
 *
 * @package MB\Bundle\ExtendingSymfonyBundle\Geo
 */
class RandomLocationGeocoder implements Geocoder
{
	/**
	 * Find geo coordinates from IP address
	 *
	 * @param string $ip
	 *
	 * @return array
	 */
	public function geocode($ip)
	{
		return new Result();
	}
}