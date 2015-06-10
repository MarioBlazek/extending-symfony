<?php

namespace MB\Bundle\GithubAuthBundle;

use MB\Bundle\GithubAuthBundle\Security\Github\SecurityFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MBGithubAuthBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
		parent::build($container);

		$extension = $container->getExtension('security');
		$extension->addSecurityListenerFactory(
			new SecurityFactory()
		);
	}
}
