<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Geo;


class RandomLocationGeocoder implements Geocoder
{

	public function getAccuracy()
	{
		return 0;
	}

	public function geocode($ip)
	{
		return new Result();
	}
}