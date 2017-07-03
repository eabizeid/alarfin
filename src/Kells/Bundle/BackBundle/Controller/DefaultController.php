<?php

namespace Kells\Bundle\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use Kells\Bundle\BackBundle\Entity\AlarfinConfiguration;
use Kells\Bundle\BackBundle\Entity\Alarfin;
use Kells\Bundle\FrontBundle\Entity\User;
use Kells\Bundle\FrontBundle\Entity\Licensee;
use Kells\Bundle\FrontBundle\Entity\Car;
use Kells\Bundle\FrontBundle\Entity\Feature;
use Kells\Bundle\FrontBundle\Entity\ImageFile;
use Kells\Bundle\FrontBundle\Entity\CarImage;
use Kells\Bundle\FrontBundle\Entity\Fotocopias;
use Kells\Bundle\FrontBundle\Entity\FotocopiasConyuge;
use Kells\Bundle\FrontBundle\Entity\Credito;
use Kells\Bundle\FrontBundle\Utils\Util;
use Kells\Bundle\FrontBundle\Entity\Model;

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
    
	public function addUserAction()
    {
    	
    	return $this->render('KellsBackBundle:Default:usuarios-agregar.html.twig');
    }
    
 	public function modifyUserAction( $id )
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('KellsFrontBundle:User');
    	$user = $repository->find($id);
    	
    	
    	return $this->render('KellsBackBundle:Default:usuarios-editar.html.twig', array("user"=>$user));
    }
    
 	public function saveUserAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$user = new User();
    	if ($request->get('id')) {
    		$user =$em->getRepository('KellsFrontBundle:User')->find($request->get('id'));
    	}  
    	
    	$user->setLastName($request->get('apellido'));
    	$user->setFirstName($request->get('nombre'));
    	$user->setMail($request->get('email'));
    	$user->setTelephone($request->get('telefono'));
    	$user->setToken("");
    	$user->setStatus(1);
    	if ($request->get('contrasena')) {
    		$user->setPassword($request->get('contrasena'));
    	}
    	
    	if (!$request->get('id')) {
    		$em->persist($user);
    	}
    	$em->flush();
    	return $this->redirect($this->generateUrl('usuarios'));
    }
    
    public function deleteUserAction( $id )
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('KellsFrontBundle:User');
    	$alarfin = $repository->find($id);
    	
    	$em->remove($alarfin);
    	$em->flush();
    	return $this->redirect($this->generateUrl('usuarios'));
    }
    
	public function concesionariasAction()
    {
    	$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:Licensee');
		$users = $repository->findAll();
        return $this->render('KellsBackBundle:Default:concesionarias.php.twig', array('concesionarias'=>$users));
    }
    
	public function addLicenseeAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('KellsFrontBundle:City');
    	$cities = $repository->findBy(array('province'=>1), array('description'=>'ASC'));
    	return $this->render('KellsBackBundle:Default:licensee-agregar.html.twig', array("cities"=> $cities));
    }
    
	public function saveLicenseeAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	if ($request->get('id')) {
    		$user =$em->getRepository('KellsFrontBundle:Licensee')->find($request->get('id'));
    	}  else {
    		$user = new Licensee();
    	}
    	
    	$repository = $em->getRepository('KellsFrontBundle:City');
    	$city = $repository->find($request->get("city"));
    	$user->setCity($city);
    	$user->setSocialReason($request->get('razonSocial'));
    	$user->setFantasyName($request->get('fantasia'));
    	$user->setCuit($request->get('cuit'));
    	$user->setMail($request->get('email'));
    	$user->setTelephone($request->get('telefono'));
    	$user->setContactName($request->get('contactName'));
        $user->setAddress($request->get('address'));
        $user->setWeb($request->get('web'));
        $user->setFacebook($request->get('facebook'));
    	$user->setToken("");
    	$user->setStatus(1);

    	if ($request->get('contrasena')) {
    		$user->setPassword($request->get('contrasena'));
    	}
        $files = $request->files;
        $mandatoryImageFile = $files->get('fotoprincipal');
        if ($mandatoryImageFile) {
            $mandatoryImage =  $this->createImage($mandatoryImageFile);
            $user->setImage($mandatoryImage);
        }


        if (!$request->get('id')) {
    		$em->persist($user);
    	}
    	$em->flush();
    	return $this->redirect($this->generateUrl('concesionariasAdmin'));
    }
    
	public function modifyLicenseeAction( $id )
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('KellsFrontBundle:Licensee');
    	$user = $repository->find($id);
    	$repository = $em->getRepository('KellsFrontBundle:City');
    	$cities = $repository->findBy(array('province'=>1), array('description'=>'ASC'));
    	
    	return $this->render('KellsBackBundle:Default:concesionarias-editar.html.twig', array("user"=>$user, "cities"=>$cities));
    }

    public function deleteLicenseeAction( $id )
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('KellsFrontBundle:Licensee');
    	$alarfin = $repository->find($id);
    	
    	$em->remove($alarfin);
    	$em->flush();
    	return $this->redirect($this->generateUrl('concesionariasAdmin'));
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
    
    
	public function publicacionesUsuarioAction($userId, $userType)
    {
    	$em = $this->getDoctrine()->getManager();
    	$user;
		$licensee;
    	if ("U" == $userType) {
			$repository = $em->getRepository('KellsFrontBundle:User');
			$user = $repository->find($userId);
    	} else {
			$repository = $em->getRepository('KellsFrontBundle:licensee');
			$licensee = $repository->find($userId);
		}
		
        return $this->render('KellsBackBundle:Default:usuario-publicaciones.php.twig', array('user'=>$user, 'licensee'=>$licensee));
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
	    $configuration->setCerokmCuotas38($request->get('cerokmCuotas38'));
	    $configuration->setCerokmCuotas40($request->get('cerokmCuotas40'));
	    $configuration->setCerokmCuotas42($request->get('cerokmCuotas42'));
	    $configuration->setCerokmCuotas44($request->get('cerokmCuotas44'));
	    $configuration->setCerokmCuotas46($request->get('cerokmCuotas46'));
	    $configuration->setCerokmCuotas48($request->get('cerokmCuotas48'));   
	
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
	    $configuration->setUnoA5Cuotas38($request->get('unoA5Cuotas38'));
	    $configuration->setUnoA5Cuotas40($request->get('unoA5Cuotas40'));
	    $configuration->setUnoA5Cuotas42($request->get('unoA5Cuotas42'));
	    $configuration->setUnoA5Cuotas44($request->get('unoA5Cuotas44'));
	    $configuration->setUnoA5Cuotas46($request->get('unoA5Cuotas46'));
	    $configuration->setUnoA5Cuotas48($request->get('unoA5Cuotas48'));
	    
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
	    $configuration->setImpuestos($request->get('impuestos'));
		
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
    
 	public function agregarAlarfinAction()
    {
		return $this->render('KellsBackBundle:Default:agregar-alarfin.html.twig');
    }
       
	public function editarAlarfinAction($id )
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('KellsBackBundle:Alarfin');
    	$alarfin = $repository->find($id);
		return $this->render('KellsBackBundle:Default:editar-alarfin.html.twig', array("alarfin"=>$alarfin));
    }
    public function saveAlarfinAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$alarfin = new Alarfin();
    	if ($request->get('id')) {
    		$alarfin =$em->getRepository('KellsBackBundle:Alarfin')->find($request->get('id'));
    	}  
    	
    	$alarfin->setLastName($request->get('apellido'));
    	$alarfin->setFirstName($request->get('nombre'));
    	$alarfin->setMail($request->get('email'));
    	if ($request->get('contrasena')) {
    		$alarfin->setPassword($request->get('contrasena'));
    	}
    	if (!$request->get('id')) {
    		$em->persist($alarfin);
    	}
    	$em->flush();
    	return $this->redirect($this->generateUrl('alarfin'));
    }
    
  	public function deleteAlarfinAction( $id )
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('KellsBackBundle:Alarfin');
    	$alarfin = $repository->find($id);
    	
    	$em->remove($alarfin);
    	$em->flush();
    	return $this->redirect($this->generateUrl('alarfin'));
    }
    
    public function publicacionesAction()
    {
    	$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:Car');
		$cars = $repository->findAll();
        return $this->render('KellsBackBundle:Default:publicaciones.html.twig', array('cars'=>$cars));
    }
    
	public function agregarPublicacionAction()
    {
    	$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:Trademark');
		$trademarks = $repository->findAll();
		$provinces = $repository->findAll();
		$repository = $em->getRepository('KellsFrontBundle:Fuel');
		$fuels = $repository->findAll();
		$repository = $em->getRepository('KellsFrontBundle:Year');
		$years = $repository->findAll();
		$repository = $em->getRepository('KellsFrontBundle:Direction');
		$directions = $repository->findAll();
		$repository = $em->getRepository('KellsFrontBundle:Transmission');
		$transmissions = $repository->findAll();
        return $this->render('KellsBackBundle:Default:agregarPublicacion.html.twig', array('trademarks'=> $trademarks, 'fuels'=>$fuels, 'years'=>$years, 
        	'directions'=>$directions, 'transmissions'=>$transmissions, 'car' => null));
    }
    
 	public function publishAction(Request $request) {
   		$user = $this->getUser();
    	
   		$carId = $request->get('carId');
   		
   		
   		
   		$title = $request->get('titulo');
   		$description = $request->get('descripcion');
   		$price = $request->get('precio');

   		$modelId = $request->get('modelo');
   		$modeloNuevo = $request->get('modeloNuevo');
   		
   		
   		$trademarkId = $request->get('marca');
   		$fuelId = $request->get('COMBUS');
   		$doorQty = $request->get('DOOR');
   		$yearId = $request->get('YEAR');
   		$kms = $request->get('KMTS');
   		$color = $request->get('COLOREXT');
   		$directionId = $request->get('DIREC');
   		$owner = $request->get('OWNER');
   		$transmissionId = $request->get('TRANS');
   		$files = $request->files;
	    $mandatoryImageFile = $files->get('fotoprincipal');
	    
        $imageFile1 = $files->get('foto1');
        $imageFile2 = $files->get('foto2');
     	$imageFile3 = $files->get('foto3');
   		$imageFile4 = $files->get('foto4');
     	$imageFile5 = $files->get('foto5');
     	$imageFile6 = $files->get('foto6');
   		
		
		if ($mandatoryImageFile) {
			$mandatoryImage =  $this->createImage($mandatoryImageFile);
		}
		
		
		if ($imageFile1) {
			$image1 = $this->createImage($imageFile1);
			
		}
		if ($imageFile2) {
			$image2 = $this->createImage($imageFile2);
		}
		if ($imageFile3) {
			$image3 = $this->createImage($imageFile3);	
		}
		if ($imageFile4) {
			$image4 = $this->createImage($imageFile4);
		}
		if ($imageFile5) {
			$image5 = $this->createImage($imageFile5);
		}
		if ($imageFile6) {
			$image6 = $this->createImage($imageFile6);
		}
	
		
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:Car');
		$car = $repository->find($carId);
		
		if (!$car) {
			$car = new Car();
		}
		if (!empty($title)) {
			$car->setTitle($title);		
		}
		if (!empty($description)) {
			$car->setDescription($description);
		}
		if (!empty($price)) {
   			$car->setPrice($price);
		}
   		$car->setKm($kms); 
   		$publicador = $request->get('publicador-nombre');
   		$car->setLicensee(null);
   		$car->setUser(null);
   		$publicadorTipo = $request->get('publicador-tipo');
   		if ($publicadorTipo == "Usuario" ) {
   			$publicadorSplitted = explode(", ", $publicador);
   			$repository = $em->getRepository('KellsFrontBundle:User');
   			$lastName = $publicadorSplitted[0];
   			$carUser = $repository->findOneBy(array('lastName'=>$lastName, 'firstName'=>$publicadorSplitted[1]));
   			$car->setUser($carUser);
   		} else {
   			$repository = $em->getRepository('KellsFrontBundle:Licensee');
   			$licensee = $repository->findOneBy(array('fantasyName'=>$publicador));
   			$car->setLicensee($licensee);
   		}
   		$car->setColor($color);

   		
 		if ($mandatoryImageFile) {
			$car->setMandatoryImage($mandatoryImage);
			$car->setMandatoryImageOriginal($mandatoryImage);
		}
		if ($imageFile1){
			$car->setImage1($image1);
			$car->setImage1Original($image1);
		}
		if ($imageFile2) {
			$car->setImage2($image2);
			$car->setImage2Original($image2);
		}
		if ($imageFile3) {
			$car->setImage3($image3);
			$car->setImage3Original($image3);
		}
		if ($imageFile4) {
			$car->setImage4($image4);
			$car->setImage4Original($image4);
		}
		if ($imageFile5) {
			$car->setImage5($image5);
			$car->setImage5Original($image5);
		}
		if ($imageFile6) {
			$car->setImage6($image6);
			$car->setImage6Original($image6);
		}
   		

		$repository = $em->getRepository('KellsFrontBundle:Fuel');
		$fuel = $repository->find($fuelId);
		$car->setFuel($fuel);
		
   		$repository = $em->getRepository('KellsFrontBundle:Trademark');
		$trademark = $repository->find($trademarkId);
   		$car->setTrademark($trademark);
		
   		
   		$repository = $em->getRepository('KellsFrontBundle:Model');
		if ($modeloNuevo ) {
			$model = new Model();
			$model->setDescription($modeloNuevo);
			$model->setTrademark($trademark);
			$em->persist($model);
			$em->flush();
			$modelId = $model->getId();
		}  
		$model = $repository->find($modelId);
		$car->setModel($model);
		
		
		$repository = $em->getRepository('KellsFrontBundle:Direction');
		$direction = $repository->find($directionId);
		$car->setDirection($direction);
		
		$repository = $em->getRepository('KellsFrontBundle:Year');
		$year = $repository->find($yearId);
		$car->setYear($year);
		
		
		$featuresList = array();
		 
		$aireAcondicionado = $request->get('AIRACON');
		Util::addToList($featuresList, $aireAcondicionado, 'AIRACON', $em);
			
    	$alarmaLuces = $request->get('ALARMLUC');
    	Util::addToList($featuresList, $alarmaLuces, 'ALARMLUC', $em);
    	
    	$aperturaBaul = $request->get('APERBAUL');
    	Util::addToList($featuresList, $aperturaBaul, 'APERBAUL', $em);
    	
		$asientosElectricos = $request->get('ASIENELEC');
		Util::addToList($featuresList, $asientosElectricos, 'APERBAUL', $em);
		
    	$asientoReg = $request->get('ASREGULA');
    	Util::addToList($featuresList, $asientoReg, 'ASREGULA', $em);
    	
    	$asientoTRebat = $request->get('ASREBAT');
    	Util::addToList($featuresList, $asientoTRebat, 'ASREBAT', $em);
    	
		$cierreCen = $request->get('BLQCNTDOOR');
		Util::addToList($featuresList, $cierreCen, 'BLQCNTDOOR', $em);
    	
		$climatizador = $request->get('CLIMAUT');
    	Util::addToList($featuresList,$climatizador, 'CLIMAUT', $em);
    	
    	$computadora = $request->get('COMPABO');
    	Util::addToList($featuresList, $computadora, 'COMPABO', $em);
		
    	$velo = $request->get('CTRLVEL');
		Util::addToList($featuresList, $velo, 'CTRLVEL', $em);
		
		$espeelec = $request->get('ESPELEC');
		Util::addToList($featuresList, $espeelec, 'ESPELEC', $em);
		
		$sensEsta = $request->get('ESTACIONAM');
		Util::addToList($featuresList, $sensEsta, 'ESTACIONAM', $em);
		
		$gps = $request->get('GPS');
		Util::addToList($featuresList, $gps, 'GPS', $em);
		
		$sensorLluvia = $request->get('SENSLL');
		Util::addToList($featuresList, $sensorLluvia, 'SENSLL', $em);
    	
		$sensorLuz = $request->get('SENSLUZ');
    	Util::addToList($featuresList, $sensorLuz,'SENSLUZ', $em);
    	
    	$faros = $request->get('FAROREG');
    	Util::addToList($featuresList, $faros,'FAROREG', $em);
		
    	$cristales = $request->get('VIDELEC');
		Util::addToList($featuresList, $cristales, 'VIDELEC', $em);
		
		$cuero = $request->get('TAPCUERO');
		Util::addToList($featuresList, $cuero, 'TAPCUERO', $em);
    	
		$techo = $request->get('TECHOCORR');
    	Util::addToList($featuresList, $techo, 'TECHOCORR', $em);
    	
		$stop = $request->get('3LUZSTOP');
		Util::addToList($featuresList, $stop, '3LUZSTOP', $em);
        
		$abs = $request->get('ABS');
        Util::addToList($featuresList, $abs, 'ABS', $em);
        
        $airbag = $request->get('AIR1');
        Util::addToList($featuresList, $airbag, 'AIR1', $em);
		
        $airbagP = $request->get('AIR2');
		Util::addToList($featuresList, $airbagP, 'AIR2', $em);
        
		$airbagLat = $request->get('AIR3');
        Util::addToList($featuresList, $airbagLat, 'AIR3', $em);
        
        $airbagCort = $request->get('AIRBAGCORT');
        Util::addToList($featuresList, $airbagCort, 'AIRBAGCORT', $em);
        
        $alarma = $request->get('ALAR');
        Util::addToList($featuresList, $alarma, 'ALAR', $em);
        
        $apoyaCab = $request->get('APCABEZA');
        Util::addToList($featuresList, $apoyaCab, 'APCABEZA', $em);
        
        $blind = $request->get('BLIND');
        Util::addToList($featuresList, $blind, 'BLIND', $em);
        
        $ctrlTrac = $request->get('CNTTRACC');
        Util::addToList($featuresList, $ctrlTrac, 'CNTTRACC', $em);
        
        $estab = $request->get('CONTR');
        Util::addToList($featuresList, $estab, 'CONTR', $em);

        $dblCtrl = $request->get('DOBTRACC');
        Util::addToList($featuresList, $dblCtrl, 'DOBTRACC', $em);

        $antineblas = $request->get('FARANTI');
        Util::addToList($featuresList, $antineblas, 'FARANTI', $em);
        
        $xenon = $request->get('FAROXEN');
        Util::addToList($featuresList, $xenon, 'FAROXEN', $em);
        
        $inmvMotor = $request->get('INMOVMOT');
        Util::addToList($featuresList, $inmvMotor, 'INMOVMOT', $em);
        
        $isofix = $request->get('ISOFIX');
        Util::addToList($featuresList, $isofix, 'ISOFIX', $em);
        
        $antiTras = $request->get('NEBLTRAS');
        Util::addToList($featuresList, $antiTras, 'NEBLTRAS', $em);
        
        $ffrenado = $request->get('REPFUERZA');
        Util::addToList($featuresList, $ffrenado, 'REPFUERZA', $em);
		
        $cd = $request->get('CAJACD');
		Util::addToList($featuresList, $cd, 'CAJACD', $em);
		
		$radio = $request->get('AM/FM');
		Util::addToList($featuresList, $radio, 'AM/FM', $em);
    	
		$bluetooth = $request->get('BLUETOOTH');
    	Util::addToList($featuresList, $bluetooth, 'BLUETOOTH', $em);
    	
    	$cargadorCd = $request->get('CARGADORCD');
    	Util::addToList($featuresList, $cargadorCd, 'CARGADORCD', $em);
    	
    	$caset = $request->get('CASET');
    	Util::addToList($featuresList, $caset, 'CASET', $em);
    	
    	$comandoSat = $request->get('COMANDOSAT');
    	Util::addToList($featuresList, $comandoSat, 'COMANDOSAT', $em);
    	
    	$dvd = $request->get('DVD');
    	Util::addToList($featuresList, $dvd, 'DVD', $em);
    	
    	$entAux = $request->get('ENTAUXILIA');
    	Util::addToList($featuresList, $entAux, 'ENTAUXILIA', $em);

    	$mp3 = $request->get('MP3');
    	Util::addToList($featuresList, $mp3, 'MP3', $em);

    	$repCd = $request->get('REPRODCD');
    	Util::addToList($featuresList, $repCd, 'REPRODCD', $em);
    	
    	$tarjetaSD = $request->get('TARJETASD');
    	Util::addToList($featuresList, $tarjetaSD, 'TARJETASD', $em);
    	
    	$usb = $request->get('USB');
    	Util::addToList($featuresList, $usb, 'USB', $em);
    	
    	$llantasAli = $request->get('LLANALEAC');
    	Util::addToList($featuresList, $llantasAli, 'LLANALEAC', $em);
		
    	$paragPintados = $request->get('PARAGOLPES');
		Util::addToList($featuresList, $paragPintados, 'PARAGOLPES', $em);
    	
		$vidPol = $request->get('VIDPOLARIZ');
    	Util::addToList($featuresList, $vidPol, 'VIDPOLARIZ', $em);
    	
    	$limpialav = $request->get('LIMPIA/LAV');
    	Util::addToList($featuresList, $limpialav, 'LIMPIA/LAV', $em);
		
    	
    	if( $carId ) {
    		foreach ($car->getFeatures() as $f) {
    			if (!in_array($f, $featuresList)) {
    				$car->removeFeature($f);
    			}
    		} 
    	 
    		foreach ($featuresList as $feature) {
    			if (!in_array($feature, $car->getFeatures()->toArray())) {
    				$car->addFeature($feature);
    			}
    		}	
    	} else { 
    	
			//CONFORT
			
			if($aireAcondicionado) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('AIRACON');
				$car->addFeature($feature);	
			}
			
			if($alarmaLuces) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('ALARMLUC');
				$car->addFeature($feature);	
			}
	
			if($aperturaBaul) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('APERBAUL');
				$car->addFeature($feature);	
			}
			if($asientosElectricos) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('ASIENELEC');
				$car->addFeature($feature);	
			}
			
			if($asientoReg) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('ASREGULA');
				$car->addFeature($feature);	
			}
			
			
			if($asientoTRebat) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('ASREBAT');
				$car->addFeature($feature);	
			}
	    	
			if($cierreCen) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('BLQCNTDOOR');
				$car->addFeature($feature);	
			}
			
			if($climatizador) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('CLIMAUT');
				$car->addFeature($feature);	
			}
			
			if($computadora) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('COMPABO');
				$car->addFeature($feature);	
			}
	     	
			if($velo) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('CTRLVEL');
				$car->addFeature($feature);	
			}
			
			if($espeelec) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('ESPELEC');
				$car->addFeature($feature);	
			}
	    	
			if($sensEsta) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('ESTACIONAM');
				$car->addFeature($feature);	
			}
			
			if($faros) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('FAROREG');
				$car->addFeature($feature);	
			}
	    	
			if($gps) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('GPS');
				$car->addFeature($feature);	
			}	
	
			if($sensorLluvia) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('SENSLL');
				$car->addFeature($feature);	
			}
			if($sensorLuz) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('SENSLUZ');
				$car->addFeature($feature);	
			}
	    	
			if($cuero) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('TAPCUERO');
				$car->addFeature($feature);	
			}
			if($techo) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('TECHOCORR');
				$car->addFeature($feature);	
			}
	    	
			if($cristales) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('VIDELEC');
				$car->addFeature($feature);	
			}		
			
			//Seguridad
	        
			if($stop) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('3LUZSTOP');
				$car->addFeature($feature);
			}	
	                                          
			if($abs) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('ABS');
				$car->addFeature($feature);
			}	
			if($airbag) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('AIR1');
				$car->addFeature($feature);
			}	
	        
			if($airbagP) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('AIR2');
				$car->addFeature($feature);
			}	
	        
			if($airbagLat) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('AIR3');
				$car->addFeature($feature);
			}	
	        
			if($airbagCort) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('AIRBAGCORT');
				$car->addFeature($feature);
			}	
	        
			if($alarma) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('ALAR');
				$car->addFeature($feature);
			}	
	        
			if($apoyaCab) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('APCABEZA');
				$car->addFeature($feature);
			}	
	        
	    	
	
	        if($blind) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('BLIND');
				$car->addFeature($feature);
			}	
	        
			if($ctrlTrac) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('CNTTRACC');
				$car->addFeature($feature);
			}	
	        
			if($estab) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('CONTR');
				$car->addFeature($feature);
			}	
	        
			if($dblCtrl) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('DOBTRACC');
				$car->addFeature($feature);
			}	
	        
			if($antineblas) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('FARANTI');
				$car->addFeature($feature);
			}	
	        
			if($xenon) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('FAROXEN');
				$car->addFeature($feature);
			}	
	        
			if($inmvMotor) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('INMOVMOT');
				$car->addFeature($feature);
			}	
	        
			if($isofix) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('ISOFIX');
				$car->addFeature($feature);
			}	
	        
			if($antiTras) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('NEBLTRAS');
				$car->addFeature($feature);
			}	
	        
			if($ffrenado) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('REPFUERZA');
				$car->addFeature($feature);
			}	
	        
			//<h5><strong>Sonido</strong></h5>
			if($cd) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('CAJACD');
				$car->addFeature($feature);
			}        
			
			if($radio) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('AM/FM');
				$car->addFeature($feature);
			}
			if($bluetooth) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('BLUETOOTH');
				$car->addFeature($feature);
			}
			
			if($cargadorCd) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('CARGADORCD');
				$car->addFeature($feature);
			}
			
	    	
			if($caset) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('CASET');
				$car->addFeature($feature);
			}
			
			if($comandoSat) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('COMANDOSAT');
				$car->addFeature($feature);
			}
			
			if($dvd) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('DVD');
				$car->addFeature($feature);
			}
			
			if($entAux) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('ENTAUXILIA');
				$car->addFeature($feature);
			}
			
			if($mp3) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('MP3');
				$car->addFeature($feature);
			}
			
			if($repCd) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('REPRODCD');
				$car->addFeature($feature);
			}
			
			if($tarjetaSD) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('TARJETASD');
				$car->addFeature($feature);
			}
			
			if($usb) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('USB');
				$car->addFeature($feature);
			}                                   
	
			//<h5><strong>Exterior</strong></h5>
			if($limpialav) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('LIMPIA/LAV');
				$car->addFeature($feature);
			}
			if($llantasAli) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('LLANALEAC');
				$car->addFeature($feature);
			}
	
			if($paragPintados) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('PARAGOLPES');
				$car->addFeature($feature);
			}
			
			if($vidPol) {
				$repository = $em->getRepository('KellsFrontBundle:Feature');
				$feature = $repository->find('VIDPOLARIZ');
				$car->addFeature($feature);
			}
    	}
		$car->setPublishedDate(new \DateTime());
		
		if (!$carId) {
			$em->persist($car);
		}
		$em->flush();

		
		if ($mandatoryImageFile){
			
			$this->corteImagen($car->getMandatoryImage()->getWebPath());
		}
 		if ($imageFile1){
			$this->corteImagen($car->getImage1()->getWebPath());
		}
		if ($imageFile2) {
			$this->corteImagen($car->getImage2()->getWebPath());
		}
		if ($imageFile3) {
			$this->corteImagen($car->getImage3()->getWebPath());
		}
		if ($imageFile4) {
			$this->corteImagen($car->getImage4()->getWebPath());
		}
		if ($imageFile5) {
			$this->corteImagen($car->getImage5()->getWebPath());
		}
		if ($imageFile6) {
			$this->corteImagen($car->getImage6()->getWebPath());
		}
	
		return $this->redirect($this->generateUrl('publicaciones'));
    }
    
    public function editCarAction($carId) {
   		$user = $this->getUser();
    	
   		$em = $this->getDoctrine()->getManager();
   		$car = $em->getRepository('KellsFrontBundle:Car')->find($carId);
		$repository = $em->getRepository('KellsFrontBundle:Trademark');
		$trademarks = $repository->findAll();
		$repository = $em->getRepository('KellsFrontBundle:Fuel');
		$fuels = $repository->findAll();
		$repository = $em->getRepository('KellsFrontBundle:Year');
		$years = $repository->findAll();
		$repository = $em->getRepository('KellsFrontBundle:Direction');
		$directions = $repository->findAll();
		$repository = $em->getRepository('KellsFrontBundle:Transmission');
		$transmissions = $repository->findAll();
        return $this->render('KellsBackBundle:Default:publicaciones-editar.html.twig', array('trademarks'=> $trademarks, 'fuels'=>$fuels, 'years'=>$years, 
        	'directions'=>$directions, 'transmissions'=>$transmissions, 'car' => $car));
    }
    
    public function deleteCarAction($carId) {
    	$em = $this->getDoctrine()->getManager();
   		$car = $em->getRepository('KellsFrontBundle:Car')->find($carId);
		$car->setStatus("FINALIZED");
		$em->flush();
    	return $this->redirect($this->generateUrl('publicaciones'));
    }
    
     public function recuperarAction() {
     	return $this->render('KellsBackBundle:Default:recuperar.html.twig', array('error'=>""));
     }
     
 	public function recuperarContrasenaAction(Request $request) {
 		$mail = $request->get('email');
 		$em = $this->getDoctrine()->getManager();
   		$user = $em->getRepository('KellsBackBundle:Alarfin')->findOneByMail($mail);
 		if (!$user) {
 				return $this->render('KellsBackBundle:Default:recuperar.html.twig', array('error'=>"Yes!"));
 		}
 		$message = \Swift_Message::newInstance()
        	->setSubject('Alarfin recuperación contraseña')
        	->setFrom('no-responder@alarfin.com.ar')
        	->setTo($user->getMail())
        	->setBody('<p>Su contraseña es:'.$user->getPassword().'</p>', 'text/html'            	
        	);
    		$this->get('mailer')->send($message);
     	return $this->render('KellsBackBundle:Default:recuperar-contrasena-ok.php.twig', array('error'=>"Yes!"));
     }	
	
     public function republishAction(Request $request) {
		$id = $request->get('id');
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:Car');
		$car = $repository->find($id);
		$car->setStatus("PUBLISHED");
		$em->flush();
		return $this->redirect($this->generateUrl('publicaciones'));
	}
	
	public function checkUserLicenseeExistsAction(Request $request) {
			
			
		$publicador = $request->get('publicador-nombre');
		$em = $this->getDoctrine()->getManager();
		try {
			if ($request->get('publicador-tipo') == "Usuario" ) {
				
	   			$publicadorSplitted = explode(", ", $publicador);
	   			if (sizeof($publicadorSplitted) > 1) {
	   				$repository = $em->getRepository('KellsFrontBundle:User');
	   				$carUser = $repository->findOneBy(array('lastName'=>$publicadorSplitted[0], 'firstName'=>$publicadorSplitted[1]));
	   			}else {
	   				$carUser = null;
	   			}
	   		} else {
	   			$repository = $em->getRepository('KellsFrontBundle:Licensee');
	   			$carUser = $repository->findBy(array('fantasyName'=>$publicador));
	   		}
	   		$output = null;
	   		if (!$carUser) {
	   			$output = "El publicador no se encuentra registrado.";
	   		}
		} catch (Exception $e) {
			$output = "El publicador no se encuentra registrado.";
		}	
   		$response = new Response();
		$response->headers->set('Content-Type', 'application/text');
		$response->setContent(json_encode($output));
		return $response;
	}
	
	
	public function retrieveUsers($userType) {
		$em = $this->getDoctrine()->getManager();
		try {
			if ($userType == "Usuario" ) {
	   			$repository = $em->getRepository('KellsFrontBundle:User');
	   			$users = $repository->findAll();
	   		} else {
	   			$repository = $em->getRepository('KellsFrontBundle:Licensee');
	   			$users = $repository->findAll();
	   		}
		
	   		$output = null;
	   		if (!$users) {
	   			$output = "El publicador no se encuentra registrado.";
	   		}else {
	   			$oputput = $users;
	   		}
		} catch (Exception $e) {
			$output = "El publicador no se encuentra registrado.";
		}
   		$response = new Response();
		$response->headers->set('Content-Type', 'application/text');
		$response->setContent(json_encode($output));
		return $response;
	}
	
	protected function createImage($imageFile) {
		if ($imageFile) {
			$image = new ImageFile();
			$image->setFile($imageFile);
			return $image;
		}
		return;
	}

	protected function createFotocopia($fotocopiaFile) {
		if ($fotocopiaFile) {
			$image = new Fotocopias();
			$image->setFile($fotocopiaFile);
			return $image;
		}
		return;
	}
	
	public function removeImageAction(Request $request) {
    	$em = $this->getDoctrine()->getManager();
   		$car = $em->getRepository('KellsFrontBundle:Car')->find($request->get('carId'));
   		$imageId =$request->get('id');
   		if ($imageId == 1) {
   			$car->setImage1(null);
   		}else if ($imageId == 2) {
   			$car->setImage2(null);
   		} else if ($imageId == 3) {
   			$car->setImage3(null);
   		} else if ($imageId == 4) {
   			$car->setImage4(null);
   		} else if ($imageId == 5) {
   			$car->setImage5(null);
   		} else if ($imageId == 6) {
   			$car->setImage6(null);
   		} 
    	$em->flush();
    	return $this->redirect($this->generateUrl('editar-publicacion', array("carId"=>$request->get('carId'))));
    }
    
    protected function corteImagen($ruta_imagen) {
    	$miniatura_ancho_maximo = 520;
		$miniatura_alto_maximo = 390;

		$info_imagen = getimagesize($ruta_imagen);
		$imagen_ancho = $info_imagen[0];
		$imagen_alto = $info_imagen[1];
		$imagen_tipo = $info_imagen['mime'];
		
		
		$proporcion_imagen = $imagen_ancho / $imagen_alto;
		$proporcion_miniatura = $miniatura_ancho_maximo / $miniatura_alto_maximo;
		if ( $proporcion_imagen > $proporcion_miniatura ){
			$miniatura_ancho = $miniatura_alto_maximo * $proporcion_imagen;
			$miniatura_alto = $miniatura_alto_maximo;
		} else if ( $proporcion_imagen < $proporcion_miniatura ){
			$miniatura_ancho = $miniatura_ancho_maximo;
			$miniatura_alto = $miniatura_ancho_maximo / $proporcion_imagen;
		} else {
			return;
		}
		
		$x = ( $miniatura_ancho - $miniatura_ancho_maximo ) / 2;
		$y = ( $miniatura_alto - $miniatura_alto_maximo ) / 2;
		
		switch ( $imagen_tipo ){
			case "image/jpg":
			case "image/jpeg":
				$imagen = imagecreatefromjpeg( $ruta_imagen );
				break;
			case "image/png":
				$imagen = imagecreatefrompng( $ruta_imagen );
				break;
			case "image/gif":
				$imagen = imagecreatefromgif( $ruta_imagen );
				break;
		}
		
		$lienzo = imagecreatetruecolor( $miniatura_ancho_maximo, $miniatura_alto_maximo );
		$lienzo_temporal = imagecreatetruecolor( $miniatura_ancho, $miniatura_alto );
		
		imagecopyresampled($lienzo_temporal, $imagen, 0, 0, 0, 0, $miniatura_ancho, $miniatura_alto, $imagen_ancho, $imagen_alto);
		imagecopy($lienzo, $lienzo_temporal, 0,0, $x, $y, $miniatura_ancho_maximo, $miniatura_alto_maximo);
		
		imagejpeg($lienzo, "$ruta_imagen", 80);
    }
    
	public function showCreditRequestAction($message = null) {

		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:Trademark');
		$trademarks = $repository->findAll();
		$repository = $em->getRepository('KellsFrontBundle:Province');
		$provinces = $repository->findAll();
		$repository = $em->getRepository('KellsFrontBundle:Fuel');
		$fuels = $repository->findAll();
		$repository = $em->getRepository('KellsFrontBundle:Year');
		$years = $repository->findAll();
		$repository = $em->getRepository('KellsFrontBundle:Direction');
		$directions = $repository->findAll();
		$repository = $em->getRepository('KellsFrontBundle:Transmission');
		$transmissions = $repository->findAll();
			
		return $this->render(
        'KellsBackBundle:Default:creditos-agregar.php.twig', array('trademarks'=> $trademarks, 'provinces'=>$provinces, 'fuels'=>$fuels, 'years'=>$years, 
        	'directions'=>$directions, 'transmissions'=>$transmissions, 'message'=>$message));

	}
	
	public function creditAction(Request $request) {
		
		$publicadorTipo = $request->get('publicador-tipo');
		$publicador = $request->get('publicador-nombre');
		
		$em = $this->getDoctrine()->getManager();
		if ($publicadorTipo == "Usuario") {
				
	   			$publicadorSplitted = explode(", ", $publicador);
	   			if (sizeof($publicadorSplitted) > 1) {
	   				$repository = $em->getRepository('KellsFrontBundle:User');
	   				$user = $repository->findOneBy(array('lastName'=>$publicadorSplitted[0], 'firstName'=>$publicadorSplitted[1]));
	   			}
	   	} else {
	   			$repository = $em->getRepository('KellsFrontBundle:Licensee');
	   			$user = $repository->findBy(array('fantasyName'=>$publicador));
	   	}
	   	
		$em = $this->getDoctrine()->getManager();
		$credito = new Credito();
			 
		$nombreSolicitante = $request->get('solicitante-nombre');
		$apellidoSolicitante = $request->get('solicitante-apellido');
		$dniSolicitante = $request->get('solicitante-dni');
		$nacimientoSolicitante = $request->get('solicitante-nacimiento');
		$estadoCivilSolicitante = $request->get('solicitante-estado-civil');
		$domicilioSolicitante = $request->get('solicitante-domicilio');
		$provinceId = $request->get('solicitante-provincia');
		$cityId = $request->get('solicitante-ciudad');
		$celularSolicitante = $request->get('solicitante-celular');
		$fijoSolicitante = $request->get('solicitante-telefono');
		$mailSolicitante = $request->get('solicitante-email');
		$actividadLaboralSolicitante = $request->get('solicitante-laboral');
		$telLaboralSolicitante = $request->get('solicitante-telefono-trabajo');
		 
		//fotocopias
		$files = $request->files;
		$solicitanteServicio = $files->get('solicitante-fotocopia-servicio');
		$solicitanteVehiculo = $files->get('solicitante-fotocopia-vehiculo');
		$solicitanteFotoDni = $files->get('solicitante-fotocopia-dni');
		$solicitanteFotoDni2 = $files->get('solicitante-fotocopia-dni2');
		$solicitanteRecibo = $files->get('solicitante-fotocopia-recibo');
		$solicitanteIngresos = $files->get('solicitante-fotocopia-ingresos');
		$solicitanteOtra1 = $files->get('solicitante-fotocopia-otra-1');
		$solicitanteOtra2 = $files->get('solicitante-fotocopia-otra-2');

		//CONYUGE
		if ($estadoCivilSolicitante == 'Casado/a') {
			$nombreConyuge = $request->get('conyuge-nombre');
			$apellidoConyuge = $request->get('conyuge-apellido');
			$dniConyuge = $request->get('conyuge-dni');
			$estadoCivilConyuge = $request->get('conyuge-estado-civil');
			$domicilioConyuge = $request->get('conyuge-domicilio');
			$conyugeProvinceId = $request->get('conyuge-provincia');
			$conyugeCityId = $request->get('conyuge-ciudad');
			$celularConyuge = $request->get('conyuge-celular');
			$fijoConyuge = $request->get('conyuge-telefono');
			$mailConyuge = $request->get('conyuge-email');
			$actividadLaboralConyuge = $request->get('conyuge-laboral');
			$telLaboralConyuge = $request->get('conyuge-telefono-trabajo');

			//fotocopias
			$files = $request->files;
			$conyugeFotoDni = $files->get('conyuge-fotocopia-dni');
			$conyugeOtra1 = $files->get('conyuge-fotocopia-otra-1');
			$conyugeOtra2 = $files->get('conyuge-fotocopia-otra-2');
			$conyugeOtra3 = $files->get('conyuge-fotocopia-otra-3');
		}
	  
		if ($publicadorTipo == 'Concesionaria') {
			//	Garante

			$nombreGarante = $request->get('garante-nombre');
			$apellidoGarante = $request->get('garante-apellido');
			$dniGarante = $request->get('garante-dni');
			$estadoCivilGarante = $request->get('garante-estado-civil');
			$domicilioGarante = $request->get('garante-domicilio');
			$provinceGarante = $request->get('garante-provincia');
			$cityGaranteId = $request->get('garante-ciudad');
			$celularGarante = $request->get('garante-celular');
			$fijoGarante = $request->get('garante-telefono');
			$mailGarante = $request->get('garante-email');
			$actividadLaboralGarante = $request->get('garante-laboral');
			$telLaboralGarante = $request->get('garante-telefono-trabajo');

			//fotocopias
			$garanteFotoDni = $files->get('garante-fotocopia-dni');
			$garanteOtra1 = $files->get('garante-fotocopia-otra-1');
			$garanteOtra2 = $files->get('garante-fotocopia-otra-2');
			$garanteRecibo = $files->get('garante-fotocopia-recibo');
			$garanteIngresos = $files->get('garante-fotocopia-ingresos');
			$garanteServicio = $files->get('garante-fotocopia-servicio');
			
			
			$credito->setNombreGarante($nombreGarante);
			$credito->setApellidoGarante($apellidoGarante);
			$credito->setDniGarante($dniGarante);
			$credito->setEstadoCivilGarante($estadoCivilGarante);
			$credito->setDomicilioGarante($domicilioGarante);
			$repository = $em->getRepository('KellsFrontBundle:Province');
			$provinciaG = $repository->find($provinceGarante);
			if ($provinciaG){
				$credito->setProvinciaGarante($provinciaG->getDescription());
			}
			$repository = $em->getRepository('KellsFrontBundle:City');
			$cityG = $repository->find($cityGaranteId);
			if ($cityG){
			$credito->setCiudadGarante($cityG->getDescription());
			}
			$credito->setCelularGarante($celularGarante);
			$credito->setFijoGarante($fijoGarante);
			$credito->setActividadLaboralGarante($actividadLaboralGarante);
			$telLaboralGarante = $request->get('Garante-telefono-trabajo');
			$credito->setTelLaboralGarante($telLaboralGarante);

			if ($garanteFotoDni) {
				$fotocopiaDniGarante = $this->createFotocopia($garanteFotoDni);
				$credito->setFotocopiaDniGarante($fotocopiaDniGarante);
			}
			if ($garanteOtra1) {
				$fotocopiaOtra1Garante = $this->createFotocopia($garanteOtra1);
				$credito->setFotocopiaOtra1Garante($fotocopiaOtra1Garante);
			}
				
			if ($garanteOtra2) {
				$fotocopiaOtra2Garante = $this->createFotocopia($conyugeOtra2);
				$credito->setFotocopiaOtra2Garante($fotocopiaOtra2Garante);
			}

			if ($garanteRecibo) {
				$fotocopiaOtraReciboGarante = $this->createFotocopia($garanteRecibo);
				$credito->setFotocopiaReciboGarante($fotocopiaOtraReciboGarante);
			}
			if ($garanteIngresos) {
				$fotocopiaIngresosGarante = $this->createFotocopia($garanteIngresos);
				$credito->setFotocopiaIngresosGarante($fotocopiaIngresosGarante);
			}
			if ($garanteServicio) {
				$fotocopiaServicioGarante = $this->createFotocopia($garanteServicio);
				$credito->setFotocopiaServicioGarante($fotocopiaServicioGarante);
			}
		}
		//Unidad a adquirir
		$marcaId = $request->get('marca');
		$modeloId = $request->get('modelo');
		$yearId = $request->get('ano');
		$value = $request->get('valor');
		$type = $request->get('tipo');
		$domain = $request->get('dominio');
		$fuelId = $request->get('combustible');

		//credito
		$montoCredito = $request->get('monto');
		$cantidadCuotas = $request->get('cuotas');
		$comments =$request->get('comentarios');


		$credito = new Credito();
		$credito->setNombreSolicitante($nombreSolicitante);
		$credito->setApellidoSolicitante($apellidoSolicitante);
		$credito->setDniSolicitante($dniSolicitante);
		$credito->setEstadoCivilSolicitante($estadoCivilSolicitante);
		$credito->setNacimientoSolicitante($nacimientoSolicitante);
		$credito->setDomicilioSolicitante($domicilioSolicitante);
		
		$repository = $em->getRepository('KellsFrontBundle:Province');
		
		$provincia = $repository->find($provinceId);
		if ($provincia) {
			$credito->setProvinciaSolicitante($provincia->getDescription());
		}
		$repository = $em->getRepository('KellsFrontBundle:City');
		$city = $repository->find($cityId);
		if ($city) {
			$credito->setCiudadSolicitante($city->getDescription());
		}
		$credito->setCelularSolicitante($celularSolicitante);
		$credito->setFijoSolicitante($fijoSolicitante);
		$credito->setMailSolicitante($mailSolicitante);
		$credito->setActividadLaboralSolicitante($actividadLaboralSolicitante);
		$telLaboralSolicitante = $request->get('solicitante-telefono-trabajo');
		$credito->setTelLaboralSolicitante($telLaboralSolicitante);
		 
		 
		if ($solicitanteServicio) {
			$fotocopiaServicioSolicitante = $this->createFotocopia($solicitanteServicio);
			$credito->setFotocopiaServicioSolicitante($fotocopiaServicioSolicitante);
		}
		
		if ($solicitanteVehiculo) {
			$fotocopiaVehiculo = $this->createFotocopia($solicitanteVehiculo);
			$credito->setFotocopiaVehiculo($fotocopiaVehiculo);
		}
		if ($solicitanteFotoDni) {
			$fotocopiaDniSolicitante = $this->createFotocopia($solicitanteFotoDni);
			$credito->setFotocopiaDniSolicitante($fotocopiaDniSolicitante);
		}
		if ($solicitanteFotoDni2) {
			$fotocopiaDni2Solicitante = $this->createFotocopia($solicitanteFotoDni2);
			$credito->setFotocopiaDni2Solicitante($fotocopiaDni2Solicitante);
		}
		if ($solicitanteRecibo) {
			$fotocopiaReciboSolicitante = $this->createFotocopia($solicitanteRecibo);
			$credito->setFotocopiaReciboSolicitante($fotocopiaReciboSolicitante);
		}
		if ($solicitanteIngresos) {
			$fotocopiaIngresosSolicitante = $this->createFotocopia($solicitanteIngresos);
			$credito->setFotocopiaIngresosSolicitante($fotocopiaIngresosSolicitante);
		}
		if ($solicitanteOtra1) {
			$fotocopiaOtra1Solicitante = $this->createFotocopia($solicitanteOtra1);
			$credito->setFotocopiaOtra1Solicitante($fotocopiaOtra1Solicitante);
		}

		if ($solicitanteOtra2) {
			$fotocopiaOtra2Solicitante = $this->createFotocopia($solicitanteOtra2);
			$credito->setFotocopiaOtra2Solicitante($fotocopiaOtra2Solicitante);
		}
	  
		 
		//Conyuge
		if ($estadoCivilSolicitante == 'Casado/a') {
			$credito->setNombreConyuge($nombreConyuge);
			$credito->setApellidoConyuge($apellidoConyuge);
			$credito->setDniConyuge($dniConyuge);
			$credito->setEstadoCivilConyuge($estadoCivilConyuge);
			$credito->setDomicilioConyuge($domicilioConyuge);
			$repository = $em->getRepository('KellsFrontBundle:Province');
			$provinciaC = $repository->find($conyugeProvinceId);
			$credito->setProvinciaConyuge($provinciaC->getDescription());
				
			$repository = $em->getRepository('KellsFrontBundle:City');
			$city = $repository->find($cityId);
			$credito->setCiudadConyuge($city->getDescription());
			$credito->setCelularConyuge($celularConyuge);
			$credito->setFijoConyuge($fijoConyuge);
			$credito->setActividadLaboralConyuge($actividadLaboralConyuge);
			$telLaboralConyuge = $request->get('Conyuge-telefono-trabajo');
			$credito->setTelLaboralConyuge($telLaboralConyuge);

			if ($conyugeFotoDni) {
				$fotocopiaDniConyuge = $this->createFotocopia($conyugeFotoDni);
				$credito->setFotocopiaDniConyuge($fotocopiaDniConyuge);
			}
			if ($conyugeOtra1) {
				$fotocopiaOtra1Conyuge = $this->createFotocopia($conyugeOtra1);
				$credito->setFotocopiaOtra1Conyuge($fotocopiaOtra1Conyuge);
			}
				
			if ($conyugeOtra2) {
				$fotocopiaOtra2Conyuge = $this->createFotocopia($conyugeOtra2);
				$credito->setFotocopiaOtra2Conyuge($fotocopiaOtra2Conyuge);
			}

			if ($conyugeOtra3) {
				$fotocopiaOtra3Conyuge = $this->createFotocopia($conyugeOtra3);
				$credito->setFotocopiaOtra3Conyuge($fotocopiaOtra3Conyuge);
			}
		}
		//Unidad a adquirir
		$repository = $em->getRepository('KellsFrontBundle:Trademark');
		$marca = $repository->find($marcaId);
		$credito->setMarca($marca->getDescription());
		$modeloId = $request->get('modelo');

		$repository = $em->getRepository('KellsFrontBundle:Model');
		$modelo = $repository->find($modeloId);
		$credito->setModelo($modelo->getDescription());

		$repository = $em->getRepository('KellsFrontBundle:Year');
		$year = $repository->find($yearId);
		$credito->setYear($year->getDescription());

		$repository = $em->getRepository('KellsFrontBundle:Fuel');
		$fuel = $repository->find($fuelId);
		$credito->setCombustible($fuel->getDescription());

		$credito->setValor($value);
		$credito->setType($type);
		$credito->setDomain($domain);
		
		$credito->setSeguro($request->get('seguro'));
		$credito->setTarjeta($request->get('tarjeta'));
		$credito->setNumeroTarjeta($request->get('tarjeta-numero'));
		$credito->setCodigoTarjeta($request->get('tarjeta-codigo'));
		$credito->setVencimientoTarjeta($request->get('tarjeta-vencimiento'));
		

		//credito
		$credito->setMontoCredito($montoCredito);
		$credito->setCantidadCuotas($cantidadCuotas);
		$credito->setGastos($request->get('gastos'));
		$credito->setPrimerVencimiento($request->get('vencimiento'));
		$credito->setComentarios($comments);

		$credito->setDate(new \DateTime());
		$credito->setUser($user->getName());


		//calculo valor cuota
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsBackBundle:AlarfinConfiguration');
		$configuration = $repository->findAll()[0];

		$intervalo0 = $configuration->getAnio0km();
		$intervalo1 = $intervalo0 - 5;
		$intervalo2 = $intervalo1 - 5;
		$intervalo3 = $intervalo2 - 5;
		$y = (int) $year->getDescription();
		$cuota = 0;
		if ($configuration->getImpuestos()) {
			$capital = (int)$montoCredito + (int)$configuration->getImpuestos();
		}
		if ($y == $intervalo0) {
			if ($cantidadCuotas == 2) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas2();
			} else if ($cantidadCuotas == 4) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas4();
			} else if ($cantidadCuotas == 6) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas6();
			} else if ($cantidadCuotas == 8) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas8();
			} else if ($cantidadCuotas == 10) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas10();
			} else if ($cantidadCuotas == 12) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas12();
			} else if ($cantidadCuotas == 14) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas14();
			} else if ($cantidadCuotas == 16) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas16();
			} else if ($cantidadCuotas == 18) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas18();
			} else if ($cantidadCuotas == 20) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas20();
			} else if ($cantidadCuotas == 22) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas22();
			} else if ($cantidadCuotas == 24) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas24();
			} else if ($cantidadCuotas == 26) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas26();
			} else if ($cantidadCuotas == 28) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas28();
			} else if ($cantidadCuotas == 30) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas30();
			} else if ($cantidadCuotas == 32) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas32();
			} else if ($cantidadCuotas == 34) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas34();
			} else if ($cantidadCuotas == 36) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas36();
			} else if ($cantidadCuotas == 38) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas38();
			} else if ($cantidadCuotas == 40) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas40();
			} else if ($cantidadCuotas == 42) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas42();
			}else if ($cantidadCuotas == 44) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas44();
			}else if ($cantidadCuotas == 46) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas46();
			} else if ($cantidadCuotas == 48) {
				$cuota = (float)$capital * (float)$configuration->getCerokmCuotas48();
			}
			
			$credito->setTasa($configuration->getCerokmtasa());
			$credito->setTea($configuration->getCerokmtea());

		} else if ($y < $intervalo0 && $y >= $intervalo1) {
			if ($cantidadCuotas == 2) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas2();
			} else if ($cantidadCuotas == 4) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas4();
			} else if ($cantidadCuotas == 6) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas6();
			} else if ($cantidadCuotas == 8) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas8();
			} else if ($cantidadCuotas == 10) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas10();
			} else if ($cantidadCuotas == 12) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas12();
			} else if ($cantidadCuotas == 14) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas14();
			} else if ($cantidadCuotas == 16) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas16();
			} else if ($cantidadCuotas == 18) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas18();
			} else if ($cantidadCuotas == 20) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas20();
			} else if ($cantidadCuotas == 22) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas22();
			} else if ($cantidadCuotas == 24) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas24();
			} else if ($cantidadCuotas == 26) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas26();
			} else if ($cantidadCuotas == 28) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas28();
			} else if ($cantidadCuotas == 30) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas30();
			} else if ($cantidadCuotas == 32) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas32();
			} else if ($cantidadCuotas == 34) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas34();
			} else if ($cantidadCuotas == 36) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas36();
			} else if ($cantidadCuotas == 38) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas38();
			} else if ($cantidadCuotas == 40) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas40();
			} else if ($cantidadCuotas == 42) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas42();
			} else if ($cantidadCuotas == 44) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas44();
			} else if ($cantidadCuotas == 46) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas46();
			} else if ($cantidadCuotas == 48) {
				$cuota = (float)$capital * (float)$configuration->getUnoA5Cuotas48();
			}
			$credito->setTasa($configuration->getUnoA5tasa());
			$credito->setTea($configuration->getUnoA5tea());
		} else if ($y < $intervalo1 && $y >= $intervalo2) {
			if ($cantidadCuotas == 2) {
				$cuota = (float)$capital * (float)$configuration->getSeisA10Cuotas2();
			} else if ($cantidadCuotas == 4) {
				$cuota = (float)$capital * (float)$configuration->getSeisA10Cuotas4();
			} else if ($cantidadCuotas == 6) {
				$cuota = (float)$capital * (float)$configuration->getSeisA10Cuotas6();
			} else if ($cantidadCuotas == 8) {
				$cuota = (float)$capital * (float)$configuration->getSeisA10Cuotas8();
			} else if ($cantidadCuotas == 10) {
				$cuota = (float)$capital * (float)$configuration->getSeisA10Cuotas10();
			} else if ($cantidadCuotas == 12) {
				$cuota = (float)$capital * (float)$configuration->getSeisA10Cuotas12();
			} else if ($cantidadCuotas == 14) {
				$cuota = (float)$capital * (float)$configuration->getSeisA10Cuotas14();
			} else if ($cantidadCuotas == 16) {
				$cuota = (float)$capital * (float)$configuration->getSeisA10Cuotas16();
			} else if ($cantidadCuotas == 18) {
				$cuota = (float)$capital * (float)$configuration->getSeisA10Cuotas18();
			} else if ($cantidadCuotas == 20) {
				$cuota = (float)$capital * (float)$configuration->getSeisA10Cuotas20();
			} else if ($cantidadCuotas == 22) {
				$cuota = (float)$capital * (float)$configuration->getSeisA10Cuotas22();
			} else if ($cantidadCuotas == 24) {
				$cuota = (float)$capital * (float)$configuration->getSeisA10Cuotas24();
			} else if ($cantidadCuotas == 26) {
				$cuota = (float)$capital * (float)$configuration->getSeisA10Cuotas26();
			} else if ($cantidadCuotas == 28) {
				$cuota = (float)$capital * (float)$configuration->getSeisA10Cuotas28();
			} else if ($cantidadCuotas == 30) {
				$cuota = (float)$capital * (float)$configuration->getSeisA10Cuotas30();
			} else if ($cantidadCuotas == 32) {
				$cuota = (float)$capital * (float)$configuration->getSeisA10Cuotas32();
			} else if ($cantidadCuotas == 34) {
				$cuota = (float)$capital * (float)$configuration->getSeisA10Cuotas34();
			} else if ($cantidadCuotas == 36) {
				$cuota = (float)$capital * (float)$configuration->getSeisA10Cuotas36();
			}
			$credito->setTasa($configuration->getSeisA10tasa());
			$credito->setTea($configuration->getSeisA10tea());
		} else if($y < $intervalo2 ) {
			if ($cantidadCuotas == 2) {
				$cuota = (float)$capital * (float)$configuration->getOnceA15Cuotas2();
			} else if ($cantidadCuotas == 4) {
				$cuota = (float)$capital * (float)$configuration->getOnceA15Cuotas4();
			} else if ($cantidadCuotas == 6) {
				$cuota = (float)$capital * (float)$configuration->getOnceA15Cuotas6();
			} else if ($cantidadCuotas == 8) {
				$cuota = (float)$capital * (float)$configuration->getOnceA15Cuotas8();
			} else if ($cantidadCuotas == 10) {
				$cuota = (float)$capital * (float)$configuration->getOnceA15Cuotas10();
			} else if ($cantidadCuotas == 12) {
				$cuota = (float)$capital * (float)$configuration->getOnceA15Cuotas12();
			} else if ($cantidadCuotas == 14) {
				$cuota = (float)$capital * (float)$configuration->getOnceA15Cuotas14();
			} else if ($cantidadCuotas == 16) {
				$cuota = (float)$capital * (float)$configuration->getOnceA15Cuotas16();
			} else if ($cantidadCuotas == 18) {
				$cuota = (float)$capital * (float)$configuration->getOnceA15Cuotas18();
			} else if ($cantidadCuotas == 20) {
				$cuota = (float)$capital * (float)$configuration->getOnceA15Cuotas20();
			} else if ($cantidadCuotas == 22) {
				$cuota = (float)$capital * (float)$configuration->getOnceA15Cuotas22();
			} else if ($cantidadCuotas == 24) {
				$cuota = (float)$capital * (float)$configuration->getOnceA15Cuotas24();
			}
			$credito->setTasa($configuration->getOnceA15tasa());
			$credito->setTea($configuration->getOnceA15tea());
		}
		 
		$credito->setValorCuota($cuota);
		 
		$em->persist($credito);
		$em->flush();

		$url = $this->generateUrl('verCredito', array('id' => $credito->getId()), true);
		$repository = $em->getRepository('KellsBackBundle:AlarfinConfiguration');
		$configuration = $repository->findAll()[0];
		
		$message1 = \Swift_Message::newInstance()
		->setSubject('Nuevo Crédito: '.$credito->getNombreSolicitante().' '.$credito->getApellidoSolicitante())
		->setFrom('no-responder@alarfin.com.ar')
		->setTo($configuration->getEmail1())
		->setBody("<p>Para acceder al nuevo crédito, por favor, haga click en: ".$url."</p>", 'text/html');

		
		$this->get('mailer')->send($message1);
		
		
		if ($configuration->getEmail2()) {
			$message1 = \Swift_Message::newInstance()
			->setSubject('Nuevo Crédito: '.$credito->getNombreSolicitante().' '.$credito->getApellidoSolicitante())
			->setFrom('no-responder@alarfin.com.ar')
			->setTo($configuration->getEmail2())
			->setBody("<p>Para acceder al nuevo crédito, por favor, haga click en: ".$url."</p>", 'text/html');
			
			$this->get('mailer')->send($message1);
		}
		
		if ($configuration->getEmail3()) {
			$message1 = \Swift_Message::newInstance()
			->setSubject('Nuevo Crédito: '.$credito->getNombreSolicitante().' '.$credito->getApellidoSolicitante())
			->setFrom('no-responder@alarfin.com.ar')
			->setTo($configuration->getEmail3())
			->setBody("<p>Para acceder al nuevo crédito, por favor, haga click en: ".$url."</p>", 'text/html');

			$this->get('mailer')->send($message1);
		}
		
		return $this->redirect($this->generateUrl('creditos', array("message"=>"Se ha enviado la solicitud exitosamente")));

	}
}
