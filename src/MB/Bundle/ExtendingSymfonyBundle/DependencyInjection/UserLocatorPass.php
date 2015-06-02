<?php

namespace MB\Bundle\ExtendingSymfonyBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class UserLocatorPass implements CompilerPassInterface
{

	/**
	 * You can modify the container here before it is dumped to PHP code.
	 *
	 * @param ContainerBuilder $container
	 *
	 * @api
	 */
	public function process(ContainerBuilder $container)
	{
		if (!$container->hasDefinition('mb.user_locator'))
		{
			return;
		}

		$serviceDefinition = $container->getDefinition('mb.user_locator');
		$tagged = $container->findTaggedServiceIds('mb.geocoder');

		foreach ($tagged as $id => $attrs) {
			$serviceDefinition->addMethodCall('addGeocoder', [ new Reference($id) ]);
		}
	}
}