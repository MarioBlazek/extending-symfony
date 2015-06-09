<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Doctrine;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class OwnerFilter extends SQLFilter
{
	/**
	 * Gets the SQL query part to add to a query.
	 *
	 * @param ClassMetaData $targetEntity
	 * @param string $targetTableAlias
	 *
	 * @return string The constraint SQL if there is available, empty string otherwise.
	 */
	public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
	{
		if ( $targetEntity->reflClass->implementsInterface('MB\Bundle\ExtendingSymfonyBundle\Doctrine\NonUserOwnedEntity') ) {
			return "";
		}

		return $targetTableAlias.'.user_id = ' . $this->getParameter('user_id');
	}
}