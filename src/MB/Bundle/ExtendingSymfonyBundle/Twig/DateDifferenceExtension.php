<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Twig;

use DateTime;
use Twig_Extension;
use Twig_SimpleFunction;

class DateDifferenceExtension extends Twig_Extension
{
	/**
	 * {@inheritDoc}
	 */
	public function getFunctions()
	{
		return [
			new Twig_SimpleFunction('date_diff', [$this, 'dateDiff']),
		];
	}

	/**
	 * Get date difference displayed in string
	 *
	 * @param DateTime $date
	 *
	 * @return string
	 */
	public function dateDiff(DateTime $date)
	{
		$difference = $this->getDifference($date, new DateTime('now'));

		return $this->differenceToString($difference);
	}


	/**
	 * Returns the name of the extension.
	 *
	 * @return string The extension name
	 */
	public function getName()
	{
		return 'mb_date_diff';
	}

	/**
	 * Get difference between two dates
	 *
	 * @param DateTime $given
	 * @param DateTime $now
	 *
	 * @return array|null
	 */
	protected function getDifference(DateTime $given, DateTime $now)
	{
		$difference = null;

		$interval = $given->diff($now);

		if ($interval) {
			$difference = [
				'years' => $interval->y,
				'months' => $interval->m,
				'days' => $interval->d,
				'hours' => $interval->h,
				'minutes' => $interval->i,
			];
		}

		return $difference;
	}

	/**
	 * Transform difference array to string
	 *
	 * @param $difference
	 *
	 * @return string
	 */
	protected function differenceToString($difference)
	{
		$years = $this->stringify($difference, 'years', 'year');
		$months = $this->stringify($difference, 'months', 'month');
		$days = $this->stringify($difference, 'days', 'day');
		$hours = $this->stringify($difference, 'hours', 'hour');
		$minutes = $this->stringify($difference, 'minutes', 'minute');


		$dateString = $years.' '.$months.' '.$days.' '.$hours.' '.$minutes;

		return rtrim($dateString, ',');

	}

	/**
	 * Transform one entry to string and set plural or singular form
	 *
	 * @param array $difference
	 * @param string $plural
	 * @param string $singular
	 *
	 * @return string
	 */
	protected function stringify($difference, $plural, $singular)
	{
		$string = '';
		if ( !$difference[$plural] == 0 ) {
			if ( $difference[$plural] > 1 ) {
				$string = "$difference[$plural] $plural,";
			} else {
				$string = "$difference[$plural] $singular,";
			}
		}

		return $string;
	}
}