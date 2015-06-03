<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application as App;
use Symfony\Component\Console\Tester\CommandTester;
use MB\Bundle\ExtendingSymfonyBundle\Command\ResizePictureCommand;

class ResizePictureCommandTest extends WebTestCase
{
	public function testCommand()
	{
		$kernel = $this->createKernel();
		$kernel->boot();

		$application = new App($kernel);
		$application->add(new ResizePictureCommand());

		$command = $application->find('picture:resize');
		$commandTester = new CommandTester($command);
		$commandTester->execute([
			'command' => $command->getName(),
			'path'	  => __DIR__.'/fixtures/pic.png',
			'-o'	  => __DIR__.'/fixtures/resized/'
		]);

		$this->assertTrue(file_exists(__DIR__.'/fixtures/resized/pic.png'));
	}
}