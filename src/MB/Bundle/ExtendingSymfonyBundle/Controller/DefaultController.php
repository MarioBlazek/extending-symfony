<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MBExtendingSymfonyBundle:Default:index.html.twig', array('name' => $name));
    }
}
