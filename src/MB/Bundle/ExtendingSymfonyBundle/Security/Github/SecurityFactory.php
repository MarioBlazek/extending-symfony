<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Security\Github;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

class SecurityFactory extends AbstractFactory
{

	/**
	 * Subclasses must return the id of a service which implements the
	 * AuthenticationProviderInterface.
	 *
	 * @param ContainerBuilder $container
	 * @param string $id The unique id of the firewall
	 * @param array $config The options array for this listener
	 * @param string $userProviderId The id of the user provider
	 *
	 * @return string never null, the id of the authentication provider
	 */
	protected function createAuthProvider(ContainerBuilder $container, $id, $config, $userProviderId)
	{
		$providerId = 'mb.github.authentication_provider'.$id;

		$definition = $container->setDefinition($providerId, new DefinitionDecorator('mb.github.authentication_provider'));

		if (isset($config['provider'])) {
			$definition->addArgument(new Reference($userProviderId));
		}

		return $providerId;
	}

	/**
	 * Subclasses must return the id of the listener template.
	 *
	 * Listener definitions should inherit from the AbstractAuthenticationListener
	 * like this:
	 *
	 *    <service id="my.listener.id"
	 *             class="My\Concrete\Classname"
	 *             parent="security.authentication.listener.abstract"
	 *             abstract="true" />
	 *
	 * In the above case, this method would return "my.listener.id".
	 *
	 * @return string
	 */
	protected function getListenerId()
	{
		return 'mb.github.authentication_listener';
	}

	/**
	 * Defines the position at which the provider is called.
	 * Possible values: pre_auth, form, http, and remember_me.
	 *
	 * @return string
	 */
	public function getPosition()
	{
		return 'pre_auth';
	}

	public function getKey()
	{
		return 'github';
	}
}