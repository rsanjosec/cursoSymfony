<?php

namespace Jazzyweb\AulasMentor\AlimentosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('JazzywebAulasMentorAlimentosBundle:Default:index.html.twig', array('name' => $name));
    }
}
