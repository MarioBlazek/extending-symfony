<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Doctrine;

class OwnerListener
{
	private $doctrine;

	private $securityContext;

	public function __constructor($doctrine, $securityContext)
	{
		$this->doctrine = $doctrine;
		$this->securityContext = $securityContext;
	}

	public function updateFilter()
	{
		$id = $this->securityContext->getToken()->getUser()->getUserId();
		$this->em->getFilters()->enable('owner_filter')->setParameter('user_id', $id);
	}
}