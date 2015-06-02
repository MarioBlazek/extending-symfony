<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Geo;

interface Geocoder
{
	/**
	 * Find geo coordinates from IP address
	 *
	 * @param string $ip
	 *
	 * @return array
	 */
	public function geocode($ip);
}