<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Geo;

use Geocoder\Geocoder as IpGeocoder;

class FreeGeoIpGeocoder implements Geocoder
{
	/**
	 * @var IpGeocoder
	 */
	private $geocoder;

	public function __construct(IpGeocoder $geocoder)
	{
		$this->geocoder = $geocoder;
	}

	public function getAccuracy()
	{
		return 100;
	}

	public function geocode($ip)
	{
		return $this->geocoder->geocode($ip);
	}
}