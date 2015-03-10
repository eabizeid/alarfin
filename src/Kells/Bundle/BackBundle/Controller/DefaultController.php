<?php

namespace Kells\Bundle\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use Kells\Bundle\BackBundle\Entity\AlarfinConfiguration;
use Kells\Bundle\BackBundle\Entity\Alarfin;
use Kells\Bundle\FrontBundle\Entity\User;
use Kells\Bundle\FrontBundle\Entity\Car;
use Kells\Bundle\FrontBundle\Entity\Feature;
use Kells\Bundle\FrontBundle\Entity\ImageFile;
use Kells\Bundle\FrontBundle\Utils\Util;

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
    	
    	return $this->render('KellsBackBundle:Default:licensee-agregar.html.twig');
    }
    
	public function saveLicenseeAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$user = new Licensee();
    	if ($request->get('id')) {
    		$user =$em->getRepository('KellsFrontBundle:Licensee')->find($request->get('id'));
    	}  
    	
    	$user->setSocialReason($request->get('razonSocial'));
    	$user->setFabtasyName($request->get('fantasy'));
    	$user->setFirstName($request->get('cuit'));
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
    	return $this->redirect($this->generateUrl('concesionarias'));
    }
    
	public function modifyLicenseeAction( $id )
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('KellsFrontBundle:Licensee');
    	$user = $repository->find($id);
    	
    	
    	return $this->render('KellsBackBundle:Default:concesionarias-editar.html.twig', array("user"=>$user));
    }

    public function deleteLicenseeAction( $id )
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('KellsFrontBundle:Licensee');
    	$alarfin = $repository->find($id);
    	
    	$em->remove($alarfin);
    	$em->flush();
    	return $this->redirect($this->generateUrl('concesionarias'));
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
        return $this->render('KellsBackBundle:Default:agregarPublicacion.html.twig', array('trademarks'=> $trademarks, 'provinces'=>$provinces, 'fuels'=>$fuels, 'years'=>$years, 
        	'directions'=>$directions, 'transmissions'=>$transmissions, 'car' => null));
    }
    
 	public function publishAction(Request $request) {
	   	$logger = $this->get('logger');
   		$user = $this->getUser();
    	
   		$carId = $request->get('carId');
   		
   		$logger->info('Es auto nuevo?: '.$carId);
   		
   		
   		$title = $request->get('titulo');
   		$description = $request->get('descripcion');
   		$price = $request->get('precio');

   		$modelId = $request->get('modelo');
   		$trademarkId = $request->get('marca');
   		$provinceId = $request->get('provincia');
   		$cityId = $request->get('ciudad');
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
   		
   		$logger->info('Nuevo auto va a ser publicado: ');
   		$logger->info('Car title: '.$title);
   		$logger->info('Trademark Car Id: '.$trademarkId);
   		$logger->info('model Car Id: '.$modelId);
		
		if ($mandatoryImageFile) {
			$mandatoryImage = new ImageFile();
			$mandatoryImage->setFile($mandatoryImageFile);
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
		$car->setTitle($title);		
   		$car->setDescription($description);
   		$car->setPrice($price);
   		$car->setKm($kms);
   		$publicador = $request->get('publicador-nombre');
   		$car->setLicensee(null);
   		$car->setUser(null);
   		if ($request->get('publicador-tipo') == "Usuario" ) {
   			$publicadorSplitted = explode(" ", $publicador);
   			$repository = $em->getRepository('KellsFrontBundle:User');
   			$carUser = $repository->findOneBy(array('lastName'=>$publicadorSplitted[0], 'firstName'=>$publicadorSplitted[1]));
   			$car->setUser($carUser);
   		} else {
   			$repository = $em->getRepository('KellsFrontBundle:Licensee');
   			$carUser = $repository->findBy(array('fantasyName'=>$publicador));
   			$car->setLicensee($carUser);
   		}
   		$car->setColor($color);
   		
   		if ($mandatoryImageFile) {
			$car->setMandatoryImage($mandatoryImage);
   		}
		if ($imageFile1){ 
			$car->addImage($image1);
		}
		if ($imageFile2) {
			$car->addImage($image2);
			$image2->setCar($car);
		}
		if ($imageFile3) {
			$car->addImage($image3);
			$image2->setCar($car);
		}
		if ($imageFile4) {
			$car->addImage($image4);
			$image2->setCar($car);
		}
		if ($imageFile5) {
			$car->addImage($image5);
			$image2->setCar($car);
		}
		if ($imageFile6) {
			$car->addImage($image6);
			$image2->setCar($car);
		}	
		
		
		
		
		
		$repository = $em->getRepository('KellsFrontBundle:Fuel');
		$fuel = $repository->find($fuelId);
		$car->setFuel($fuel);
		$logger->info('Trademark Car description: '.$car->getFuel()->getDescription());
		
   		$repository = $em->getRepository('KellsFrontBundle:Trademark');
		$trademark = $repository->find($trademarkId);
   		$car->setTrademark($trademark);
		$logger->info('Trademark Car description: '.$car->getTrademark()->getDescription());
		
		$repository = $em->getRepository('KellsFrontBundle:Model');
		$model = $repository->find($modelId);
   		$car->setModel($model);
		
   		$repository = $em->getRepository('KellsFrontBundle:Province');
		$province = $repository->find($provinceId);
		$car->setProvince($province);
		
		$repository = $em->getRepository('KellsFrontBundle:City');
		$city = $repository->find($cityId);
		$car->setCity($city);
		
		
		
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
    			$logger->info("feature: ".$f->getDescription());
    			if (!in_array($f, $featuresList)) {
    				$logger->info("no está en la lista");
    				$car->removeFeature($f);
    			}
    		} 
    	 
    		$logger->info("Agregar");
    		foreach ($featuresList as $feature) {
    			$logger->info("feature: ".$feature->getDescription());
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
		
		
		return $this->redirect($this->generateUrl('publicaciones'));
    }
    
    public function editCarAction($carId) {
	   	$logger = $this->get('logger');
   		$user = $this->getUser();
    	
   		$em = $this->getDoctrine()->getManager();
   		$car = $em->getRepository('KellsFrontBundle:Car')->find($carId);
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
        return $this->render('KellsBackBundle:Default:publicaciones-editar.html.twig', array('trademarks'=> $trademarks, 'provinces'=>$provinces, 'fuels'=>$fuels, 'years'=>$years, 
        	'directions'=>$directions, 'transmissions'=>$transmissions, 'car' => $car));
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
        	->setFrom('no-reply@alarfin.com.ar')
        	->setTo($user->getMail())
        	->setBody('<p>Su contraseña es:'.$user->getPassword().'</p>', 'text/html'            	
        	);
    		$this->get('mailer')->send($message);
     	return $this->render('KellsBackBundle:Default:recuperar-contrasena-ok.php.twig', array('error'=>"Yes!"));
     }	
	
     public function republishAction(Request $request) {
		$logger = $this->get('logger');
		$id = $request->get('id');
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:Car');
		$car = $repository->find($id);
		$car->setStatus("PUBLISHED");
		$em->flush();
		return $this->redirect($this->generateUrl('publicaciones'));
	}
	
	public function checkUserLicenseeExistsAction(Request $request) {
			$logger = $this->get('logger');
			$logger->info("checking user");
			
			
		$publicador = $request->get('publicador-nombre');
		$logger->info("publicador-nombre".$publicador);
		$em = $this->getDoctrine()->getManager();
		if ($request->get('publicador-tipo') == "Usuario" ) {
			
   			$publicadorSplitted = explode(" ", $publicador);
   			 $repository = $em->getRepository('KellsFrontBundle:User');
   			$carUser = $repository->findOneBy(array('lastName'=>$publicadorSplitted[0], 'firstName'=>$publicadorSplitted[1]));
   		} else {
   			$repository = $em->getRepository('KellsFrontBundle:Licensee');
   			$carUser = $repository->findBy(array('fantasyName'=>$publicador));
   		}
   		$output = null;
   		if (!$carUser) {
   			$output = "El publicador no se encuentra registrado.";
   		}
   		$response = new Response();
		$response->headers->set('Content-Type', 'application/text');
		$response->setContent(json_encode($output));
		return $response;
	}
     
}
