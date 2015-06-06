<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Form\Type;

use MB\Bundle\ExtendingSymfonyBundle\Form\Transformer\GeoTransformer;
use MB\Bundle\ExtendingSymfonyBundle\Geo\Coordinate;
use MB\Bundle\ExtendingSymfonyBundle\Geo\UserLocator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
	/**
	 * @var UserLocator
	 */
	private $locator;

	/**
	 * Constructor
	 *
	 * @param Map $map
	 * @param UserLocator $locator
	 */
	public function __construct(Map $map, UserLocator $locator)
	{
		$this->map = $map;
		$this->locator = $locator;
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->addViewTransformer(new GeoTransformer());

		$builder->addEventListener(FormEvents::PRE_SET_DATA,
			function(FormEvent $event) use ($builder) {
				$data = $event->getData();

				if ( null === $data->getLatitude() ) {
					$geocoded = $this->locator->getUserCoordinates();
					$value = new Coordinate($geocoded->getLatitude(),
						$geocoded->getLongitude()
					);

					$event->setData($value);
				}
			});
	}

	/**
	 * {@inheritDoc}
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults([
			'widget' => 'mb_coordinate',
			'compound'	=> false,
			'data_class' => 'MB\Bundle\ExtendingSymfonyBundle\Geo\Coordinate',
			'data'	=> new Coordinate(),
		]);
	}

	/**
	 * {@inheritDoc}
	 */
	public function buildView(FormView $view, FormInterface $form, array $options)
	{
		$center = new GMCoordinate($form->getData()->getLatitude() ,$form->getData()->getLongitude());

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