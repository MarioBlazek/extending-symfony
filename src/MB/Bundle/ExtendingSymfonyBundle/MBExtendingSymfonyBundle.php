<?php

namespace MB\Bundle\ExtendingSymfonyBundle;

use MB\Bundle\ExtendingSymfonyBundle\DependencyInjection\UserLocatorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MBExtendingSymfonyBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
		parent::build($container);

		$container->addCompilerPass(new UserLocatorPass());
	}
}
