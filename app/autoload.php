<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;
use Doctrine\ODM\MongoDB\Types\Type;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

Type::addType('coordinates', 'MB\Bundle\ExtendingSymfonyBundle\Document\CoordinateType');

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
