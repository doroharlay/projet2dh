<?php

namespace Projet2\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

 /**
     * @Route("/admin")
     * 
  */


class AccueilAdminController extends Controller
{
    
     /**
     * @Route("/", name="adminroot")
     * @Template("BackBundle:AccueilAdmin:accueiladmin.html.twig")
     * 
     */
    public function AccueilAdminAction()
    {
        return array();
    }
}
