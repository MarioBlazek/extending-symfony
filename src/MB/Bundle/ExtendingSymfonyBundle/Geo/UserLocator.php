<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Geo;

use Symfony\Component\HttpFoundation\Request;
use Geocoder\Geocoder;

class UserLocator
{
	protected $userIp;

	protected $geocoders = [];

	public function __construct(Request $request)
	{
		$this->userIp = $request->getClientIp();

		if ($this->userIp == '127.0.0.1') {
			$this->userIp = '114.247.144.250';
		}
	}

	public function addGeocoder(Geocoder $geocoder)
	{
		$this->geocoders[] = $geocoder;
	}

	public function getUserGeoBoundaries($precision = 0.3)
	{
		$result = $this->geocoder->geocode($this->userIp);
		$lat = $result->getLatitude();
		$long = $result->getLongitude();
		$latMax = $lat + $precision;
		$latMin = $lat - $precision;
		$longMax = $long + $precision;
		$longMin = $long - $precision;

		return ['lat_max' => $latMax, 'lat_min' => $latMin,
			'long_max' => $longMax, 'long_min' => $longMin];
	}

	public function getBestGeocoder()
	{
		// @TODO find best geocoder
	}
}