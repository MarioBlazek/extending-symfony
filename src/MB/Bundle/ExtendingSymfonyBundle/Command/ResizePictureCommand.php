<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Command;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ResizePictureCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this
			->setName('picture:resize')
			->setDescription('Resize a single picture')
			->addArgument('path', InputArgument::REQUIRED, 'Path to the picture you want to resize')
			->addOption('size', null, InputOption::VALUE_OPTIONAL, 'Size of the output picture (defaults 300 pixels)')
			->addOption('out', 'o', InputOption::VALUE_OPTIONAL, 'Folder which to output the picture (default same as original  picture)');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$path = $input->getArgument('path');
		$size = $input->getOption('size') ?: 300;
		$out = $input->getOption('out');

		$imagine = new Imagine();
		$image = $imagine->open($path);
		$box = new Box($size, $size);

		$filename = basename($path);

		// resize
		$image->resize($box)->save($out.'/'.$filename);

		$output->writeln(sprintf('%s --> %s', $path, $out));
	}
}