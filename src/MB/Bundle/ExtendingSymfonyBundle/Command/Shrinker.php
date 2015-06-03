<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Command;

use Imagine\Image\Box;

class Shrinker
{
	protected $imagine;

	public function __construct($imagine)
	{
		$this->imagine = $imagine;
	}

	public function shrinkImage($path, $out, $size)
	{
		$image = $this->imagine->open($path);
		$box = new Box($size, $size);
		$filename = basename($path);
		$image->resize($box)->save($out.'/'.$filename);
	}
}