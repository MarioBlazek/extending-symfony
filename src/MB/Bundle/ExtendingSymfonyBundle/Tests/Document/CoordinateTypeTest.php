<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Tests\Document;


use MB\Bundle\ExtendingSymfonyBundle\Document\Meetup;
use MB\Bundle\ExtendingSymfonyBundle\Geo\Coordinate;
use Symfony\Bundle\FrameworkBundle\Tests\Functional\WebTestCase;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class CoordinateTypeTest extends WebTestCase
{
	public function testMapping()
	{
		$client = static::createClient();
		$dm = $client->getContainer()->get('doctrine.odm.mongodb.document_manager');

		$meetup = new Meetup();
		$name = uniqid();
		$meetup->setName($name);
		$meetup->setLocation(new Coordinate(33, 75));

		$dm->persist($meetup);
		$dm->flush();

		$m = new \MongoClient();
		$db = $m->extending;
		$collection = $db->Meetup;

		$met = $collection->findOne(['name' => $name]);

		$this->assertTrue(is_array($met['location']));
		$this->assertTrue($met['location'][0] === 33);

		$newName = uniqid();
		$collection->insert([
			'name' => $newName,
			'location' => [11, 22]
		]);

		$dbmeetup = $dm->getRepository('MBExtendingSymfonyBundle:Meetup')->findOneBy(['name' => $newName]);

       	$this->assertTrue($dbmeetup->getLocation() instanceof Coordinate);
	}

	/**
	 * @expectedException UnexpectedTypeException
	 */
	public function testTypeException()
	{
		$client = static::createClient();
		$dm = $client->getContainer()->get('doctrine.odm');
		$name = uniqid();
		$meetup = new Meetup();
		$meetup->setName($name);
		$meetup->setLocation([1,2]);

		$dm->persist($meetup);
		$dm->flush();
	}
}