<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Security\Annotation;

/**
 * @Annotation
 */
class ValidateUser
{
	private $validationGroup;

	public function __construct(array $parameters)
	{
		$this->validationGroup = $parameters['value'];
	}

	public function getValidationGroup()
	{
		return $this->validationGroup;
	}
}