<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name')
			->add('latitude')
			->add('longitude');
	}

	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'MB\Bundle\ExtendingSymfonyBundle\Entity\Event',
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'mb_event';
	}
}