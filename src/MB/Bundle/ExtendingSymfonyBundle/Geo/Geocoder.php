<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Geo;

interface Geocoder
{
	public function getAccuracy();

	public function geocode($ip);
}