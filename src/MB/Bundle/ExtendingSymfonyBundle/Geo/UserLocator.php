<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Geo;

use Symfony\Component\HttpFoundation\Request;

class UserLocator
{
	/**
	 * @var string
	 */
	protected $userIp;

	/**
	 * @var Geocoder
	 */
	protected $geocoder;

	/**
	 * Constructor
	 *
	 * @param Request $request
	 */
	public function __construct(Request $request)
	{
		$this->userIp = $request->getClientIp();

		if ($this->userIp == '127.0.0.1') {
			// probabbly here would be better if get external ip address
			// from some service like ip chicken
			$this->userIp = '114.247.144.250';
		}
	}

	/**
	 * Set Geocoder
	 *
	 * @param Geocoder $geocoder
	 */
	public function setGeocoder(Geocoder $geocoder)
	{
		$this->geocoder = $geocoder;
	}

	/**
	 * Calculate boundaries
	 *
	 * @param float $precision
	 *
	 * @return array
	 */
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

	/**
	 * Get current user coordinates
	 *
	 * @return array
	 */
	public function getUserCoordinates()
	{
		return $this->geocoder->geocode($this->userIp);
	}

	/**
	 * Get country code for given IP
	 *
	 * @return mixed
	 */
	public function getCountryCode()
	{
		return $this->geocoder->geocode($this->userIp)->getCountryCode();
	}
}