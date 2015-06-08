<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document
 */
class Meetup
{
	/**
	 * @ODM\Id
	 */
	protected $id;

	/**
	 * @ODM\String
	 */
	protected $name;

	/**
	 * @ODM\Field(type="coordinates")
	 */
	protected $location;

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getLocation()
	{
		return $this->location;
	}

	/**
	 * @param mixed $location
	 */
	public function setLocation($location)
	{
		$this->location = $location;
	}


}