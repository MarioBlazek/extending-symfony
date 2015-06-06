<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Ivory\GoogleMapBundle\Entity\Coordinate as GMCoordinate;
use Ivory\GoogleMap\Map;

class CoordinateType extends AbstractType
{
	/**
	 * @var
	 */
	private $map;

	public function __construct(Map $map)
	{
		$this->map = $map;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{

	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults([
			'widget' => 'mb_coordinate',
			'compound'	=> false,
			'data_class' => 'MB\Bundle\ExtendingSymfonyBundle\Geo\Coordinate',
		]);
	}

	public function buildView(FormView $view, FormInterface $form, array $options)
	{
		$center = new GMCoordinate(45.8124666 ,15.9840722);

		$this->map->setCenter($center);
		$this->map->setMapOption('zoom', 10);

		$view->vars['map'] = $this->map;
	}

	/**
	 * Returns the name of this type.
	 *
	 * @return string The name of this type
	 */
	public function getName()
	{
		return 'mb_coordinate';
	}
}