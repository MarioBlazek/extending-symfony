<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Doctrine;

use Doctrine\DBAL\LockMode;
use Doctrine\ORM\Event\LifecycleEventArgs;

class VersionableListener
{
	public function prePersist(LifecycleEventArgs $args)
	{
		$entity = $args->getEntity();

		$versionable = in_array(
			'MB\Bundle\ExtendingSymfonyBundle\Doctrine\Versionable',
			(new \ReflectionClass($entity))->getTraitNames()
		);

		if ($versionable) {
			$entity->setVersion(1);
		}
	}

	public function preUpdate(LifecycleEventArgs $args)
	{
		$entity = $args->getEntity();
		$em = $args->getEntityManager();

		$versionable = in_array(
			'MB\Bundle\ExtendingSymfonyBundle\Doctrine\Versionable',
			(new \ReflectionClass($entity))->getTraitNames()
		);

		if ($versionable) {
			$em->lock($entity, LockMode::OPTIMISTIC, $entity->getVersion());
			$version = $entity->getVersion();
			$uow = $em->getUnitOfWork();
			$uow->propertyChanged($entity, 'version', $version, $version + 1);
		}
	}
}