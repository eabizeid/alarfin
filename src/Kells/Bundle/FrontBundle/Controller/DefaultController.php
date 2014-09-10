<?php

namespace Kells\Bundle\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('KellsFrontBundle:Default:index.html.twig', array('name' => $name));
    }
}
