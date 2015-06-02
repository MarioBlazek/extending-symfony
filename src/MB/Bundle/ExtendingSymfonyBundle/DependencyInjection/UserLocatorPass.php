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

		$highestAccuracy = 0;
		$highestAccuracyId = 0;
		foreach ($tagged as $id => $attrs) {

			if ($attrs[0]['accuracy'] > $highestAccuracy) {
				$highestAccuracy = $attrs[0]['accuracy'];
				$highestAccuracyId = $id;
			}
		}

		$serviceDefinition->addMethodCall('setGeocoder', [ new Reference($highestAccuracyId) ]);
	}
}