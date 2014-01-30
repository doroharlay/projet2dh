<?php

namespace Projet2\FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Projet2\FrontBundle\Form\ContactType;


class RegistrationController extends Controller
{
    
    /**
     *
     * @Route("/registration", name="registration")
     * @Template("FrontBundle:Registration:registration.html.twig")
     */

    
    public function indexAction(Request $request)
    {
        $user = new ContactType();
        $form = $this->createForm($user);
        $form->handleRequest($request);

               
        if ($form->isValid()) {
               $dataForm = $form->getData();
               
               
               //insertion ds la BDD
               $manager = $this->getDoctrine()->getManager();
               //$dataForm->setRoles(array('ROLE_ADMIN'));
               var_dump($dataForm);
               
               //mettre en mémoire ds la BDD
               $manager->persist($dataForm);
               
               
               //envoyer ds la BDD
               $manager->flush();
               //redirection vers la home avec un message de confirmation
               $this->getRequest()->getSession()->getFlashBag()->add('info', 'Your account was successfully creating. Thank you for joining us!');
               return $this->redirect($this->generateUrl('root'));
               
               //$url = $this->generateUrl('confirmation');
               //return $this->redirect($url);
               
         }
         
        return array(
                        'formulaire' => $form->createView(),
                    );


    }
    
        /**
     *
     * @Route("/confirmation", name="confirmation")
     * @Template("FrontBundle:Registration:confirmation.html.twig")
     */


    public function confirmAction()
    {
        return array(
            'message' => 'Merci d\'avoir créer votre compte',
            );
    }


}
