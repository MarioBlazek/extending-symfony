<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Tests\Doctrine;

use MB\Bundle\ExtendingSymfonyBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Tests\Functional\WebTestCase;

class VersionableTest extends WebTestCase
{
	public function testVersionAdded()
	{
		$client = static::createClient();

		$meetup = new Event();
		$em = $client->getContainer()->get('doctrine')->getManager();

		$this->assertTrue($meetup->getVersion() === null);

		$em->persist($meetup);
		$em->flush();

		$em->refresh($meetup);

		$this->assertTrue($meetup->getVersion() === 1);
	}

	/**
	 * @expectedException \Exception
	 */
	public function testRefuseOutdated()
	{
		$client = static::createClient();
		$meetup = new Event();
		$em = $client->getContainer()->get('doctrine')->getManager();
		$em->persist($meetup);
		$em->flush();

		$meetup->setName('myEvent');
		$meetup->setVersion(0);
		$em->flush();
	}

	public function testIncrementedVersion()
	{
		$client = static::createClient();
		$meetup = new Event();
		$em = $client->getContainer()->get('doctrine')->getManager();
		$em->persist($$meetup);
		$em->flush();

		$this->assertTrue($meetup->getVersion() === 1);

		$em->refresh($meetup);
		$meetup->setName('test event');
		$em->flush();
		$this->assertTrue($meetup->getVersion() === 2);
	}
}