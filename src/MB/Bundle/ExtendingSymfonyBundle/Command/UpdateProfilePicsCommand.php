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

		$command = $this->getApplication()->find('picture:resize');
		$arguments = array(
			'command' => 'picture:resize',
			'--size'  => $size,
			'--out'   => $out,
		);

		$users = $this->getContainer()
					->get('fos_user.user_manager')
					->findUsers();

		$progress = $this->getHelperSet()->get('progress');
		$progress->start($output, count($users));

		foreach ($users as $user) {
			$arguments['path'] = $user->getPicture();
			$input = new ArrayInput($arguments);
			$command->run($input, $output);

			$progress->advance();
		}

		$output->writeln('');
		$output->writeln('<info>Success!</info>');
	}
}