<?php

namespace Kells\Bundle\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use Kells\Bundle\BackBundle\Entity\AlarfinConfiguration;

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
    
	public function configurationAction()
    {
    	$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsBackBundle:AlarfinConfiguration');
		$configuration = new AlarfinConfiguration();
		$configurations = $repository->findAll();
		if ($configurations) {
			$configuration = $configurations[0];
		}  
        return $this->render('KellsBackBundle:Default:configuracion.html.twig', array("message"=>"", "configuration"=>$configuration ));
    }
    
	public function saveChangesAction(Request $request)
    {
    	
    	$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsBackBundle:AlarfinConfiguration');
		$configuration = new AlarfinConfiguration();
		$configurations = $repository->findAll();
		if ($configurations) {
			$configuration = $configurations[0];
		}  
		
		$configuration->setEmail1($request->get('email1'));
		$configuration->setEmail2($request->get('email2'));
		$configuration->setEmail3($request->get('email3'));
		
	    $configuration->setCerokmtasa($request->get('cerokmtasa'));
	    $configuration->setCerokmtea($request->get('cerokmtea'));
	    $configuration->setUnoA5tasa($request->get('unoA5tasa'));
	    $configuration->setUnoA5tea($request->get('unoA5tea'));
	    $configuration->setSeisA10tasa($request->get('seisA10tasa'));
	    $configuration->setSeisA10tea($request->get('seisA10tea'));
	    $configuration->setOnceA15tasa($request->get('onceA15tasa'));
	    $configuration->setOnceA15tea($request->get('onceA15tea'));
	    $configuration->setCerokmCuotas2($request->get('cerokmCuotas2'));
	    $configuration->setCerokmCuotas4($request->get('cerokmCuotas4'));
	    $configuration->setCerokmCuotas6($request->get('cerokmCuotas6'));
	    $configuration->setCerokmCuotas8($request->get('cerokmCuotas8'));
	    $configuration->setCerokmCuotas10($request->get('cerokmCuotas10'));
	    $configuration->setCerokmCuotas12($request->get('cerokmCuotas12'));
	    $configuration->setCerokmCuotas14($request->get('cerokmCuotas14'));
	    $configuration->setCerokmCuotas16($request->get('cerokmCuotas16'));
	    $configuration->setCerokmCuotas18($request->get('cerokmCuotas18'));
	    $configuration->setCerokmCuotas20($request->get('cerokmCuotas20'));
	    $configuration->setCerokmCuotas22($request->get('cerokmCuotas22'));
	    $configuration->setCerokmCuotas24($request->get('cerokmCuotas24'));
	    $configuration->setCerokmCuotas26($request->get('cerokmCuotas26'));
	    $configuration->setCerokmCuotas28($request->get('cerokmCuotas28'));
	    $configuration->setCerokmCuotas30($request->get('cerokmCuotas30'));
	    $configuration->setCerokmCuotas32($request->get('cerokmCuotas32'));
	    
	    $configuration->setCerokmCuotas34($request->get('cerokmCuotas34'));
	
	    $configuration->setCerokmCuotas36($request->get('cerokmCuotas36'));
	
	    $configuration->setUnoA5Cuotas2($request->get('unoA5Cuotas2'));
	    $configuration->setUnoA5Cuotas4($request->get('unoA5Cuotas4'));
	
	    $configuration->setUnoA5Cuotas6($request->get('unoA5Cuotas6'));
	
	    $configuration->setUnoA5Cuotas8($request->get('unoA5Cuotas8'));
	    $configuration->setUnoA5Cuotas10($request->get('unoA5Cuotas10'));
	    $configuration->setUnoA5Cuotas12($request->get('unoA5Cuotas12'));
	    $configuration->setUnoA5Cuotas14($request->get('unoA5Cuotas14'));
	    $configuration->setUnoA5Cuotas16($request->get('unoA5Cuotas16'));
	    $configuration->setUnoA5Cuotas18($request->get('unoA5Cuotas18'));
	    $configuration->setUnoA5Cuotas20($request->get('unoA5Cuotas20'));
	    $configuration->setUnoA5Cuotas22($request->get('unoA5Cuotas22'));
	    $configuration->setUnoA5Cuotas24($request->get('unoA5Cuotas24'));
	    $configuration->setUnoA5Cuotas26($request->get('unoA5Cuotas26'));
	    $configuration->setUnoA5Cuotas28($request->get('unoA5Cuotas28'));
	    $configuration->setUnoA5Cuotas30($request->get('unoA5Cuotas30'));
	    $configuration->setUnoA5Cuotas32($request->get('unoA5Cuotas32'));
	    $configuration->setUnoA5Cuotas34($request->get('unoA5Cuotas34'));
	    $configuration->setUnoA5Cuotas36($request->get('unoA5Cuotas36'));
	    $configuration->setSeisA10Cuotas2($request->get('seisA10Cuotas2'));
	    $configuration->setSeisA10Cuotas4($request->get('seisA10Cuotas4'));
	    $configuration->setSeisA10Cuotas6($request->get('seisA10Cuotas6'));
	    $configuration->setSeisA10Cuotas8($request->get('seisA10Cuotas8'));
	
	    $configuration->setSeisA10Cuotas10($request->get('seisA10Cuotas10'));
	    
	    $configuration->setSeisA10Cuotas12($request->get('seisA10Cuotas12'));
	
	    $configuration->setSeisA10Cuotas14($request->get('seisA10Cuotas14'));
	
	    $configuration->setSeisA10Cuotas16($request->get('seisA10Cuotas16'));
	
	    $configuration->setSeisA10Cuotas18($request->get('seisA10Cuotas18'));
	
	    $configuration->setSeisA10Cuotas20($request->get('seisA10Cuotas20'));
	
	    $configuration->setSeisA10Cuotas22($request->get('seisA10Cuotas22'));
	
	    $configuration->setSeisA10Cuotas24($request->get('seisA10Cuotas24'));
	
	    $configuration->setSeisA10Cuotas26($request->get('seisA10Cuotas26'));
	
	    $configuration->setSeisA10Cuotas28($request->get('seisA10Cuotas28'));
	
	    $configuration->setSeisA10Cuotas30($request->get('seisA10Cuotas30'));
	
	    $configuration->setSeisA10Cuotas32($request->get('seisA10Cuotas32'));
	
	    $configuration->setSeisA10Cuotas34($request->get('seisA10Cuotas34'));
	
	    $configuration->setSeisA10Cuotas36($request->get('seisA10Cuotas36'));
	
	    $configuration->setOnceA15Cuotas2($request->get('onceA15Cuotas2'));
	
	    $configuration->setOnceA15Cuotas4($request->get('onceA15Cuotas4'));
	
	    $configuration->setOnceA15Cuotas6($request->get('onceA15Cuotas6'));
	    $configuration->setOnceA15Cuotas8($request->get('onceA15Cuotas8'));
	
	    $configuration->setOnceA15Cuotas10($request->get('onceA15Cuotas10'));
	    $configuration->setOnceA15Cuotas12($request->get('onceA15Cuotas12'));
	 
	    $configuration->setOnceA15Cuotas14($request->get('onceA15Cuotas14'));
	
	    $configuration->setOnceA15Cuotas16($request->get('onceA15Cuotas16'));
	 
	    $configuration->setOnceA15Cuotas18($request->get('onceA15Cuotas18'));
	    $configuration->setOnceA15Cuotas20($request->get('onceA15Cuotas20'));
	    $configuration->setOnceA15Cuotas22($request->get('onceA15Cuotas22'));
	    $configuration->setOnceA15Cuotas24($request->get('onceA15Cuotas24'));
		
	    if (!$configurations) {
			$em->persist($configuration);
	    }
	    $em->flush();
		
		$message="EXITO";
        return $this->render('KellsBackBundle:Default:configuracion.html.twig', array("message"=>$message,"configuration"=>$configuration));
    }
    
    public function creditosAction()
    {
    	
    	$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:Credito');
		$creditos = $repository->findAll();
		return $this->render('KellsBackBundle:Default:creditos.html.twig', array("creditos"=>$creditos));
		
    }
    
	public function showCreditoAction($id)
    {
    	
    	$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:Credito');
		$credito = $repository->find($id);
		return $this->render('KellsBackBundle:Default:verCredito.html.twig', array("credito"=>$credito,  "tipoUsuario"=>"Usuario"));
		
    }
    
    public function alarfinAction()
    {
    	$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsBackBundle:Alarfin');
		$alarfines = $repository->findAll();
		return $this->render('KellsBackBundle:Default:alarfin.html.twig', array('alarfines'=>$alarfines));
    }
       
}
