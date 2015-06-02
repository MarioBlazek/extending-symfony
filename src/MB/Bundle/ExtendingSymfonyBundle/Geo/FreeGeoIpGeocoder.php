<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Geo;

use Geocoder\Geocoder as IpGeocoder;

class FreeGeoIpGeocoder implements Geocoder
{
	/**
	 * @var IpGeocoder
	 */
	private $geocoder;

	/**
	 * Constructor
	 *
	 * @param IpGeocoder $geocoder
	 */
	public function __construct(IpGeocoder $geocoder)
	{
		$this->geocoder = $geocoder;
	}

	/**
	 * Find geo coordinates from IP address
	 *
	 * @param string $ip
	 *
	 * @return array
	 */
	public function geocode($ip)
	{
		return $this->geocoder->geocode($ip);
	}
}