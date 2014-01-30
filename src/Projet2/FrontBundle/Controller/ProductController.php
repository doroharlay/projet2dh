<?php

namespace Projet2\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Projet2\BackBundle\Entity\User;

class ProductController extends Controller

{
    /**
     * @Route("/type", name="roottype")
     * @Template("FrontBundle:Product:index.html.twig")
     * 
     */

    public function indexAction()
    {
        $listeTypes = $this->getDoctrine()->getManager()->getRepository('BackBundle:Type')->findAll();
        
        return array('listeTypes' => $listeTypes);
    }
    
     /**
     * @Route("/type/{id}", name="onetype")
     * @Template("FrontBundle:Product:type.html.twig")
     * 
     */

    public function oneTypeAction($id)
    {
        
        $listeProducts = $this->getDoctrine()->getManager()->getRepository('BackBundle:Product')->getProductsByType($id);
        
        return array('listeProducts' => $listeProducts);
    }
    
     /**
     * @Route("/product/{id}", name="oneproduct")
     * @Template("FrontBundle:Product:oneproduct.html.twig")
     * 
     */
    public function oneProduct($id)
    {
        $product = $this->getDoctrine()->getManager()->getRepository('BackBundle:Product')->find($id);
        
        return array('product' => $product);
    }

}

