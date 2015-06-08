<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Doctrine;

use Doctrine\ORM\Mapping as ORM;

trait Versionable
{
	/**
	 * @ORM\Column(name="version", type="integer", length=255)
	 * @ORM\Version
	 */
	private $version;

	/**
	 * @return mixed
	 */
	public function getVersion()
	{
		return $this->version;
	}

	/**
	 * @param mixed $version
	 */
	public function setVersion($version)
	{
		$this->version = $version;
	}
}