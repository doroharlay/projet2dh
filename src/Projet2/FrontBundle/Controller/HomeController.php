<?php

namespace Projet2\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Projet2\BackBundle\Entity\User;

class HomeController extends Controller

{
    /**
     * @Route("/", name="root")
     * @Template("FrontBundle:Home:home.html.twig")
     * 
     */

    public function indexAction()
    {     
        return array();
    }
    

}

