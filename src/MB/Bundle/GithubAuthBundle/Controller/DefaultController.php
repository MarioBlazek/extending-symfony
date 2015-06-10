<?php

namespace MB\Bundle\GithubAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MBGithubAuthBundle:Default:index.html.twig', array('name' => $name));
    }
}
