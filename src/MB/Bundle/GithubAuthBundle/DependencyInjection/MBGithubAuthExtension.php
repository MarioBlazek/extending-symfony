<?php

namespace MB\Bundle\GithubAuthBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MBGithubAuthExtension extends Extension
{
	private $namespace = 'mb_github_auth';

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

		$this->setParameters(
			$container, $config, $this->namespace
		);
    }

	public function setParameters($container, $config, $ns)
	{
		foreach ($config as $key => $value) {
			$container->setParameter(
				$ns . '.' . $key,
				$value
			);
		}
	}
}
