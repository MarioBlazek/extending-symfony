<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Tests\Twig;

use MB\Bundle\ExtendingSymfonyBundle\Twig\JSExtension;
use Twig_Test_IntegrationTestCase;

class JSExtensionTest extends Twig_Test_IntegrationTestCase
{

	protected function getExtensions()
	{
		return array(
			new JSExtension(),
		);
	}

	protected function getFixturesDir()
	{
		return __DIR__.'/Fixtures/';
	}
}