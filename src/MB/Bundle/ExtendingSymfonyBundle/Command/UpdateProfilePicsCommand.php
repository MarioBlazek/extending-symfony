<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateProfilePicsCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this
			->setName('picture:profile:update')
			->setDescription('Resize all user\'s pictures to a new size');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$dialog = $this
					->getHelperSet()
					->get('dialog');

		$size = $dialog->ask($output, 'Size of the final pictures (300): ', '300');
		$out = $dialog->ask($output, 'Output folder: ');

		$users = $this->getContainer()
					->get('fos_user.user_manager')
					->findUsers();

		$progress = $this->getHelperSet()->get('progress');
		$progress->start($output, count($users));

		foreach ($users as $user) {
			$path = $user->getPicture();
			$this->getContainer()
				->get('mb.shrinker')
				->shrinkImage($path, $out, $size);

			$progress->advance();
		}

		$output->writeln('');
		$output->writeln('<info>Success!</info>');
	}
}