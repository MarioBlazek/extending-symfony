<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Geo;

class Result
{
	public function getLatitude()
	{
		return rand(-85, 85);
	}

	public function getLongitude()
	{
		return rand(-180, 180);
	}

	public function getCountryCode()
	{
		return 'CN';
	}
}