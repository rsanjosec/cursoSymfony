<?php

namespace Casa\FinanzasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return new Response('<html><body><h1>Hola caracola!</h1></body></html>');
        //return $this->render('FinanzasBundle:Default:index.html.twig', array('name' => $name));
    }
}
