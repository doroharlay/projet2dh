<?php

namespace Projet2\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Projet2\BackBundle\Entity\CommandProduct;
use Projet2\BackBundle\Entity\Command;

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
            
            echo '<br><br><br><br><br><br><br><br><br><br>';
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

            return $this->redirect($this->generateUrl('roottype'));

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
        
        //récupérer le tableau de quantité
        $_POST = $request->request->all();
       
        //mettre à jour les quantités
        foreach ($panier['product'] as $key => $value) {
            $panier['product'][$key]['qty'] = $_POST['qty'][$key];
        }
        
        //pousser la mise à jour en session
        $session->set('panier', $panier);
        
        return array('panier' => $panier);       
    }
    
     /**
     * @Route("/validatebasket", name="validatebasket")
     * @Template("FrontBundle:Basket:basket.html.twig")
     * 
     */
    
    public function validateBasketAction()
    {

        echo '<br><br><br><br><br><br><br>';
        // récupérer le panier
        $request = $this->get('request'); 
        $session = $request->getSession();
        $panier = $session->get('panier');
        
        echo 'panier AVANT envoi en base "command-produit';
        var_dump($panier);
        
        
        //création d'une nouvelle commandeProduct vide
        //$commandProduct = new \Projet2\BackBundle\Entity\CommandProduct;

        
        /*récupérer le user***********************************************/
        
        // On récupère le service
        $security = $this->container->get('security.context');
        // On récupère le token
        $token = $security->getToken();
        // Si la requête courante n'est pas derrière un pare-feu, $token est null
        // Sinon, on récupère l'utilisateur
        $user = $token->getUser();
        // Si l'utilisateur courant est anonyme, $user vaut « anon. »
        // Sinon, c'est une instance de notre entité User, on peut l'utiliser normalement
        $user->getUsername();
 
        echo('mon user qui a passé la commande : ');
        var_dump($user);
        
        
        //créer une nouvelle Command avec un Id
        $em = $this->getDoctrine()->getManager();
        $command = new Command();
        $command->setUser($user);
        $command->setIsValidate(TRUE);
        $totalPrice = '';
        $command->setTotalPrice($totalPrice);        
        //pour créer un id de commande
        $em->persist($command);
        $em->flush();
        
      
        //on hydrate l'objet commandProduct
        foreach ($panier['product'] as $i => $product) {
            $commandProduct= new CommandProduct();
            echo 'ma commande vide :';
            var_dump($commandProduct);
            //$commandProduct[$i]->setProduct($product['id']);
            $commandProduct->setProductQty($product['qty']);
            //on récupére les produits du panier sous forme d'objet avant insertion dans la BDD
            $product = $em->getRepository('BackBundle:Product')->find($product['id']);
            $commandProduct->setProduct($product);
            $commandProduct->setCommand($command);
            
            //echo 'couples produit/qty:';
            //echo $product['id'].'/';
            //echo $product['qty'];
            echo 'ma commande product ds la boucle à l\'itération: '.$i;
            var_dump($commandProduct);

            $em->persist($commandProduct);
            $em->flush();
            

        }

        
        return array('panier' => $panier);       
    }
}

