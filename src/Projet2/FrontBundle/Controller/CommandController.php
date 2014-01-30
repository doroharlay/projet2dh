<?php

namespace Projet2\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Projet2\BackBundle\Entity\CommandProduct;
use Projet2\BackBundle\Entity\Command;

class CommandController extends Controller

{
    
     /**
     * @Route("/validatebasket", name="validatebasket")
     * @Template("FrontBundle:Basket:basket.html.twig")
     * 
     */
    public function validateBasketAction()
    {

        //on vérifie que le client est authenfié (autre que anonymous)
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')== false ) {
            $this->get('session')->getFlashBag()->add('info', 'Please login in order to validate your basket');
         
            return $this->redirect($this->generateUrl('login'));
        }
        
        /******************** on récupère le panier********************************/
        
        $request = $this->get('request'); 
        $session = $request->getSession();
        $panier = $session->get('panier');
        
        /****************************récupérer le user*****************************/
        
        // On récupère le USer qui a passé la commande
        $security = $this->container->get('security.context');
        // On récupère le token
        $token = $security->getToken();
        // Si la requête courante n'est pas derrière un pare-feu, $token est null
        // Sinon, on récupère l'utilisateur
        $user = $token->getUser();
        // Si l'utilisateur courant est anonyme, $user vaut « anon. »
        // Sinon, c'est une instance de notre entité User, on peut l'utiliser normalement
        $user->getUsername();
 
        /*************créer une nouvelle Command avec un Id************************/
        
        $em = $this->getDoctrine()->getManager();
        $command = new Command();
        $command->setUser($user);
        $command->setIsValidate(TRUE);
        $totalPrice = '';
        $command->setTotalPrice($totalPrice);        
        //pour créer l'id de commande
        $em->persist($command);
        $em->flush();
        
      
        /*********************on crée un nouvel objet CommandProduct, on l'hydrate et on l'enregistre dans la BDD**********************/
        
        foreach ($panier['product'] as $i => $product) {
            $commandProduct= new CommandProduct();
            $commandProduct->setProductQty($product['qty']);
            
            //on récupére les produits du panier sous forme d'objet avant insertion dans la BDD
            $product = $em->getRepository('BackBundle:Product')->find($product['id']);
            
            $commandProduct->setProduct($product);
            $commandProduct->setCommand($command);
            
            $em->persist($commandProduct);
            $em->flush();
        }
       

        /*********************on crée un nouvel objet CommandProduct, on l'hydrate et on l'enregistre dans la BDD**********************/
        
        /****************************on vide le panier***************************/
        $panier['product'] = array();
        $session->set('panier', $panier);

        
        $this->get('session')->getFlashBag()->add('info', 'Your command was successfully registered');
        return $this->redirect( $this->generateUrl('root'));
      
    }
}

