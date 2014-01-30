<?php

namespace Projet2\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BasketController extends Controller

{
    
     /**
     * @Route("/basket", name="basket")
     * @Template("FrontBundle:Basket:basket.html.twig")
     * 
     */

    public function basketAction()
    {
        $session = $this->getRequest()->getSession();
        $panier = $session->get('panier');
        
        return array('panier' => $panier);    
    }
    
    
    /**
     * @Route("/addbasket/{id}", name="addbasket")
     * @Template("FrontBundle:Basket:basket.html.twig")
     * 
     */

    public function addBasketAction($id)
    {
        
        //on récupère la requête
        $request = $this->get('request'); 
        
        if( $request->getMethod() == 'POST' ){
            

            /*on récupère les Request POST Parameters*/
            $_POST = $request->request->all();
            $qty = $_POST['qty'];

            //on récupère l'objet à ajouter de la BDD
            $product = $this->getDoctrine()->getManager()->getRepository('BackBundle:Product')->find($id);

           //on récupère la session
            $session = $this->getRequest()->getSession();

            //on crée un panier vide
            if(!$session->has('panier'))
            {
                $session->set('panier', array(
                                        'product' => array()                                        
                                        )
                            );
            }

            $panier = $session->get('panier');

           //le panier est vide
            if (count($panier['product']) == 0){
                array_push( $panier['product'], array(
                                        "id" => $id,
                                        "name" => $product->getName(),
                                        "qty"=> $qty,
                                        "price"=>$product->getPrice()
                                                )
                        ); 
            } else {

                //le panier n'est pas vide
                echo 'compte du panier'.count($panier['product']);
                for ($i=0; $i< count($panier['product']); $i++){
                    if($id == $panier['product'][$i]['id'])
                    {
                        echo 'lobjet est déjà dans le tableau à la position'.$i;
                        $isInArray = true;
                        $position = $i;
                        break;
                    }
                }
                if (isset($isInArray)){
                    echo 'j ingremente ma qte';
                    $panier['product'][$position]['qty']+= $qty;
                } else {

                echo 'je rajoute mon deuxième produit';
                array_push( $panier['product'], array(
                                       "id" => $id,
                                       "name" => $product->getName(),
                                       "qty"=> $qty,
                                       "price"=>$product->getPrice()
                                           )
                          );
                }
            }


            $session->set('panier', $panier);
            
            $session->getFlashBag()->add('info', 'The product was added in your basket');
            
            return $this->redirect($this->generateUrl('oneproduct', array('id' => $id)) );

       }
    }
     
    /**
     * @Route("/removebasket/{id}", name="removebasket")
     * @Template("FrontBundle:Basket:basket.html.twig")
     * 
     */

    public function removeBasketAction($id)
    {
        echo '<br><br><br><br><br><br><br><br><br>';
        $session = $this->getRequest()->getSession();
        $panier = $session->get('panier');
        
        for ($i=0; $i< count($panier['product']); $i++){
            if($id == $panier['product'][$i]['id'])
            {
                array_splice($panier['product'], $i, 1);
            }
        }
        
        $session->set('panier', $panier);
        
        return array('panier' => $panier);

    }
    
    
     /**
     * @Route("/majbasket", name="majbasket")
     * @Template("FrontBundle:Basket:basket.html.twig")
     * 
     */
    
    public function majBasketAction()
    {

        // récupérer le panier
        $request = $this->get('request'); 
        $session = $request->getSession();
        $panier = $session->get('panier');
        
        //récupérer le tableau des quantités postées
        $_POST = $request->request->all();
       
        //mettre à jour les quantités dans le tableau panier
        foreach ($panier['product'] as $key => $value) {
            $panier['product'][$key]['qty'] = $_POST['qty'][$key];
        }
        
        //pousser la mise à jour en session
        $session->set('panier', $panier);
        
        $session->getFlashBag()->add('info', 'Your basket was updated');
            
        return array('panier' => $panier);       
    }
    
    
}

