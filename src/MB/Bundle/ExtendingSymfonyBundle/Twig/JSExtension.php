<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Twig;

use Twig_Environment;
use Twig_Extension;
use Twig_Loader_String;

class JSExtension extends Twig_Extension
{
	protected $javascripts = [];

	protected $environment;

	public function __construct()
	{
		$this->environment = new Twig_Environment(new Twig_Loader_String());
	}

	public function getFunctions()
	{
		return [
			new \Twig_SimpleFunction('jslater', [$this, 'jslater']),
			new \Twig_SimpleFunction('jsnow', [$this, 'jsnow']),
		];
	}

	public function jslater($src)
	{
		$this->javascripts[] = $src;
	}

	public function jsnow()
	{
		$template = '{% for script in scripts %}<script type="text/javascript" src={{ script }}" /> {% endfor %}';

		$scripts = array_unique($this->javascripts);

		return $this->environment->render($template, compact('scripts'));
	}

	/**
	 * Returns the name of the extension.
	 *
	 * @return string The extension name
	 */
	public function getName()
	{
		return 'mb_js_extension';
	}
}