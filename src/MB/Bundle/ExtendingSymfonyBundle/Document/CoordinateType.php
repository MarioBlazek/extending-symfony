<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Document;

use Doctrine\ODM\MongoDB\Types\Type;
use MB\Bundle\ExtendingSymfonyBundle\Geo\Coordinate;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class CoordinateType extends Type
{
	public function convertToPHPValue($value)
	{
		return new Coordinate($value[0], $value[1]);
	}

	public function convertToDatabaseValue($value)
	{
		if ( !$value instanceof Coordinate ) {
			throw new UnexpectedTypeException($value, 'MB\Bundle\ExtendingSymfonyBundle\Geo\Coordinate');
		}

		return [
			$value->getLatitude(),
			$value->getLongitude()
		];
	}

	public function closureToPHP()
	{
		return '$return = new \MB\Bundle\ExtendingSymfonyBundle\Geo\Coordinate($value[0], $value[1]);';
	}
}