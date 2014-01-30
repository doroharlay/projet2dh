<?php

namespace Projet2\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


    /**
     * @Route("/login", name="login")
     * @Template("FrontBundle:Authentication:authentication.html.twig")
     * 
     */
class AuthenticationController extends Controller
{
        public function AuthenticationAction()
        {
                // Si le visiteur est déjà identifié, on le redirige vers l'accueil

                if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                        return $this->redirect($this->generateUrl('login'));
                    }

                $request = $this->getRequest();
                $session = $request->getSession();

                // On vérifie s'il y a des erreurs d'une précédente soumission du formulaire

                if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
                    $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
                } else {
                    $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
                    $session->remove(SecurityContext::AUTHENTICATION_ERROR);
                }

                return $this->render('FrontBundle:Authentication:authentication.html.twig',
                    array(
                    // Valeur du précédent nom d'utilisateur entré par l'internaute
                    'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                    'error' => $error,
                    ));
         }
}
