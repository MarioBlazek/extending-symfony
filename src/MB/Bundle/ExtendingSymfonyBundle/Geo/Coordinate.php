<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Geo;

use Ivory\GoogleMapBundle\Entity\Coordinate as GMCoordinate;

class Coordinate extends GMCoordinate
{
	protected $longitude;

	protected $latitude;

	public function __construct($latitude = null, $longitude = null)
	{
		$this->latitude = $latitude;
		$this->longitude = $longitude;
	}

	/**
	 * @return null
	 */
	public function getLongitude()
	{
		return $this->longitude;
	}

	/**
	 * @param null $longitude
	 */
	public function setLongitude($longitude)
	{
		$this->longitude = $longitude;
	}

	/**
	 * @return null
	 */
	public function getLatitude()
	{
		return $this->latitude;
	}

	/**
	 * @param null $latitude
	 */
	public function setLatitude($latitude)
	{
		$this->latitude = $latitude;
	}

	public function __toString()
	{
		return '('.$this->latitude.', '.$this->longitude.')';
	}

	public static function createFromString($string)
	{
		if (strlen($string) < 1) {
			return new self;
		}

		$string = str_replace(['(', ')', ' '], ' ', $string);
		$data = explode(',', $string);

		if ($data[0] === "" || $data[1] === "") {
			return new self;
		}

		return new self($data[0], $data[1]);
	}

	public function toGmaps()
	{
		return new GMCoordinate($this->latitude, $this->longitude);
	}
}