<?php

namespace Kells\Bundle\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('KellsBackBundle:Default:index.html.twig');
    }

	public function usuariosAction()
    {
    	$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:User');
		$users = $repository->findAll();
        return $this->render('KellsBackBundle:Default:usuarios.php.twig', array('users'=>$users));
    }
    
    public function adminLoginAction()
    {
    	 $request = $this->getRequest();
        $session = $request->getSession();
 
        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }
 
        return $this->render('KellsBackBundle:Default:adminLogin.html.twig', array(
            // last username entered by the user
            'last_mail' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }
    
    
	public function publicacionesUsuarioAction($userId)
    {
    	$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:User');
		$user = $repository->find($userId);
		
		$logger = $this->get('logger');
		$logger->info("user ".$userId);
        return $this->render('KellsBackBundle:Default:usuario-publicaciones.php.twig', array('user'=>$user));
    }
    
}
