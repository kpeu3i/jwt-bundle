<?php

namespace Kpeu3i\JwtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('Kpeu3iJwtBundle:Default:index.html.twig', array('name' => $name));
    }
}
