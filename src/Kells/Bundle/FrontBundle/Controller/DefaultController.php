<?php

namespace Kells\Bundle\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;

use Kells\Bundle\FrontBundle\Form\Type\SearchType;
use Kells\Bundle\FrontBundle\Form\Model\Search;

use Kells\Bundle\FrontBundle\Form\Type\RegistrationType;
use Kells\Bundle\FrontBundle\Form\Model\Registration;
use Kells\Bundle\FrontBundle\Form\Type\UserRegistrationType;
use Kells\Bundle\FrontBundle\Form\Model\UserRegistration;
use Kells\Bundle\FrontBundle\Entity\Car;
use Kells\Bundle\FrontBundle\Entity\Feature;
use Kells\Bundle\FrontBundle\Entity\ImageFile;
use Kells\Bundle\FrontBundle\Entity\CarImage;
use Kells\Bundle\FrontBundle\Entity\Fotocopias;
use Kells\Bundle\FrontBundle\Entity\FotocopiasConyuge;
use Kells\Bundle\FrontBundle\Entity\Credito;

use Kells\Bundle\FrontBundle\Utils\Util;

class DefaultController extends Controller
{
    public function indexAction() {
    	$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'),));

    	$repository = $this->getDoctrine()->getRepository('KellsFrontBundle:Car');

		$cars =  $repository->findBy(array('status'=>"PUBLISHED"), array('publishedDate' => 'DESC'), 12);
        return $this->render('KellsFrontBundle:Default:index.html.twig', array( 'cars' => $cars, 'form' => $form->createView() ));
    }
    
    public function detailsAction( $carId ) {
    	$repository = $this->getDoctrine()->getRepository('KellsFrontBundle:Car');

		$car =  $repository->find($carId);
		
		$logger = $this->get('logger');
		$logger->info('car ==> '.$car->getId());
		$logger->info('car ==> '.$car->getMandatoryImage()->getPath());
		
		$logger->info('car ==> '.sizeof($car->getImages()));
		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'),));
		
        return $this->render('KellsFrontBundle:Default:ficha.html.twig', array( 'car' => $car , 'features' => $car->getFeatures(), 'form'=>$form->createView()));
    }
    
    public function searchCarAction(Request $request) {
    	
    	$form = $this->createForm(new SearchType(), new Search());

		$form->handleRequest($request);
		
		$search = $form->getData();
		
    	$repository = $this->getDoctrine()->getRepository('KellsFrontBundle:Car');
    	$query = $repository->createQueryBuilder('c')
    		->leftJoin('c.model', 'm')
    		->leftJoin('c.trademark', 't')
    		->where('m.description LIKE :pattern')
    		->orwhere('t.description LIKE :pattern')
    		->setParameter('pattern', $search->getPattern())
    		->getQuery();
    		
		$cars =  $query->getResult();
		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'),));
        return $this->render('KellsFrontBundle:Default:index.html.twig', array( 'cars' => $cars, 'form' => $form->createView() ));
    }
    
    /* ******************** User Registration ***********************************************  */
    public function userRegistrationAction() {
    	$registration = new UserRegistration();
		$form = $this->createForm(new UserRegistrationType(), $registration, array('action' => $this->generateUrl('user_create'),));
    	
     	return $this->render('KellsFrontBundle:Default:userRegistration.html.twig', array('form' => $form->createView()));
    }
    
    
    
    public function userConfirmAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm(new UserRegistrationType(), new UserRegistration());

		$form->handleRequest($request);

		if ($form->isValid()) {
			$registration = $form->getData();

			$user = $registration->getUser(); 
			$user->setStatus(false);
			$user->setToken(Util::getToken());
			$em->persist($user);
			$em->flush();

			$url = 'http://'.$_SERVER['SERVER_NAME'].':8000/app_dev.php/user/register/confirm/'.$user->getToken();
			$message = \Swift_Message::newInstance()
        	->setSubject('Confirmar su registracion')
        	->setFrom('eduardo.abizeid@gmail.com')
        	->setTo($user->getMail())
        	->setBody('<p>Gracias por registrarse</p>'.
        	'<p>Para terminar con el registro por favor haga click en el siguiente vínculo </p>'.
        	'<p><a href="'.$url.'">Confirmar</a></p>', 'text/html'
            	
        	);
    		$this->get('mailer')->send($message);
			
			return $this->redirect($this->generateUrl('user_message_confirm'));
		}

		return $this->render(
        'KellsFrontBundle:Default:userRegistration.html.twig',
		array('form' => $form->createView())
		);
	}
	
	public function userRegisterConfirmAction($token) {
		if ($token) {
			$em = $this->getDoctrine()->getManager();
			$repository = $em->getRepository('KellsFrontBundle:User');
			$user = $repository->findOneByToken($token);
			if ($user) {
				//delete token and change status
				$user->setToken('');
				$user->setStatus(true);
				$em->flush();
				
				return $this->redirect($this->generateUrl('kells_front_homepage'));
			}
		}
			return $this->redirect($this->generateUrl('userRegistration'));
	}

	
	/* ******************** Licensee Registration ***********************************************  */
    
 	public function licenseeRegistrationAction() {
    	$registration = new UserRegistration();
		$form = $this->createForm(new UserRegistrationType(), $registration, array('action' => $this->generateUrl('user_create'),));
    	
     	return $this->render('KellsFrontBundle:Default:userRegistration.html.twig', array('form' => $form->createView()));
    }
    
    
    
    public function licenseeConfirmAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm(new UserRegistrationType(), new UserRegistration());

		$form->handleRequest($request);

		if ($form->isValid()) {
			$registration = $form->getData();

			$user = $registration->getUser(); 
			$user->setStatus(false);
			$user->setToken(Util::getToken());
			$em->persist($user);
			$em->flush();

			$url = 'http://'.$_SERVER['SERVER_NAME'].':8000/app_dev.php/user/register/confirm/'.$user->getToken();
			$message = \Swift_Message::newInstance()
        	->setSubject('Confirmar su registracion')
        	->setFrom('eduardo.abizeid@gmail.com')
        	->setTo($user->getMail())
        	->setBody('<p>Gracias por registrarse</p>'.
        	'<p>Para terminar con el registro por favor haga click en el siguiente vínculo </p>'.
        	'<p><a href="'.$url.'">Confirmar</a></p>', 'text/html'
            	
        	);
    		$this->get('mailer')->send($message);
			
			return $this->redirect($this->generateUrl('user_message_confirm'));
		}

		return $this->render(
        'KellsFrontBundle:Default:userRegistration.html.twig',
		array('form' => $form->createView())
		);
	}
	
	public function licenseeRegisterConfirmAction($token) {
		if ($token) {
			$em = $this->getDoctrine()->getManager();
			$repository = $em->getRepository('KellsFrontBundle:User');
			$user = $repository->findOneByToken($token);
			if ($user) {
				//delete token and change status
				$user->setToken('');
				$user->setStatus(true);
				$em->flush();
				
				return $this->redirect($this->generateUrl('kells_front_homepage'));
			}
		}
			return $this->redirect($this->generateUrl('userRegistration'));
	}
    	
	public function registerMessageConfirmAction() {
		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'),));
		return $this->render(
        'KellsFrontBundle:Default:messageRegistration.html.twig', array("form"=>$form->createView()));
		
	}
	
	
 	public function userLoginAction() {
        $request = $this->getRequest();
        $session = $request->getSession();
 
        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }
 
        return $this->render('KellsFrontBundle:Default:userLogin.html.twig', array(
            // last username entered by the user
            'last_mail' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }
    
    
	public function userMyPublicationsAction() {
		$user = $this->get('security.context')->getToken()->getUser();
		
		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'),));
		return $this->render(
        'KellsFrontBundle:Default:misPublicaciones.html.twig', array("form"=>$form->createView(), "myCars" => $user->getCars()));
		
	}
	
	public function toPublishAction() {
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
		
		$user = $this->get('security.context')->getToken()->getUser();
		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'), ));
		return $this->render(
        'KellsFrontBundle:Default:publicar.html.twig', array("form"=>$form->createView(), 'trademarks'=> $trademarks, 'provinces'=>$provinces, 'fuels'=>$fuels, 'years'=>$years, 
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
			$logger->info('mandatoryImage: '.$mandatoryImageFile->getClientOriginalName());
			$logger->info('mandatoryImage extension: '.$mandatoryImageFile->guessExtension());
   		
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
   		$car->setUser($user);
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
		
		
		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'),));
		
		return $this->redirect($this->generateUrl('user_myPublications'));
    }
    
   
    public function getModelsAction(Request $request) {
		
    	$logger = $this->get('logger');
		$id = $request->get('id');
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:Trademark');
		$trademark = $repository->find($id);
		$logger->info('trademark: '.$trademark->getId().' ');
		$logger->info('models: ');
		$output = array();
		foreach  ($trademark->getModels() as $model) {
			$logger->info('model: '.$model->getId());
			 $output[] = array(
              'id' => $model->getId(),
              'description' => $model->getDescription(),
          );
		}
		
		$response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($output));
        return $response;
		
	}
	
	public function getCitiesAction(Request $request) {
		$logger = $this->get('logger');
		$id = $request->get('id');
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:Province');
		$province = $repository->find($id);
		$logger->info('province: '.$province->getId().' ');
		$logger->info('cities: ');
		$output = array();
		foreach  ($province->getCities() as $city) {
			$logger->info('city: '.$city->getId());
			 $output[] = array(
              'id' => $city->getId(),
              'description' => $city->getDescription(),
          );
		}
		
		$response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($output));
        return $response;
		
	}
	
	protected function createImage($imageFile) {
		if ($imageFile) {
			$image = new CarImage();
			$image->setFile($imageFile);
			return $image;
		}
		return;
	}
	
	
	public function toFinalizeAction(Request $request) {
		$logger = $this->get('logger');
		$id = $request->get('id');
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:Car');
		$car = $repository->find($id);
		$car->setStatus("FINALIZED");
		$em->flush();
		return $this->redirect($this->generateUrl('user_myPublications'));
	}
	
	public function toEditAction(Request $request) {
		$logger = $this->get('logger');
		$id = $request->get('id');
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:Car');
		$car = $repository->find($id);
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
		
		$user = $this->get('security.context')->getToken()->getUser();
		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'), ));
		return $this->render(
        'KellsFrontBundle:Default:publicar.html.twig', array("form"=>$form->createView(), 'trademarks'=> $trademarks, 'provinces'=>$provinces, 'fuels'=>$fuels, 'years'=>$years, 
        	'directions'=>$directions, 'transmissions'=>$transmissions, 'car'=>$car));
		
	}
	
	public function showCreditRequestAction() {
		
		$user = $this->get('security.context')->getToken()->getUser();
		
		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'),));
		
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
		 
		$logger = $this->get('logger');
		$logger->info("user_role: ".$user->getRoles()[0]);
		return $this->render(
        'KellsFrontBundle:Default:solicitar-credito-usuario.html.twig', array("form"=>$form->createView(), "userRole"=>$user->getRoles()[0], 'trademarks'=> $trademarks, 'provinces'=>$provinces, 'fuels'=>$fuels, 'years'=>$years, 
        	'directions'=>$directions, 'transmissions'=>$transmissions));
		
	}
	
		
    public function creditAction(Request $request) {
	   	$logger = $this->get('logger');
   		$user = $this->getUser();
    	
   		
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
	    $solicitanteFotoDni = $files->get('solicitante-fotocopia-dni');
	    $solicitanteRecibo = $files->get('solicitante-fotocopia-recibo');
	    $solicitanteIngresos = $files->get('solicitante-fotocopia-ingresos');
	    $solicitanteOtra1 = $files->get('solicitante-fotocopia-otra-1');
	    $solicitanteOtra2 = $files->get('solicitante-fotocopia-otra-2');
	 
	    
	    //CONYUGE

	    $nombreConyuge = $request->get('conyuge-nombre');
   		$apellidoConyuge = $request->get('conyuge-apellido');
   		$dniConyuge = $request->get('conyuge-dni');
   		$estadoCivilConyuge = $request->get('conyuge-estado-civil');
   		$domicilioConyuge = $request->get('conyuge-domicilio');
   		$provinceId = $request->get('conyuge-provincia');
   		$cityId = $request->get('conyuge-ciudad');
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
	 
	    
	    if ($user->getRoles()[0] == 'ROLE_USER') {
	    	//	Garante

		    $nombreGarante = $request->get('garante-nombre');
	   		$apellidoGarante = $request->get('garante-apellido');
	   		$dniGarante = $request->get('garante-dni');
	   		$estadoCivilGarante = $request->get('garante-estado-civil');
	   		$domicilioGarante = $request->get('garante-domicilio');
	   		$provinceId = $request->get('garante-provincia');
	   		$cityId = $request->get('garante-ciudad');
			$celularGarante = $request->get('garante-celular');  		
			$fijoGarante = $request->get('garante-telefono');
			$mailGarante = $request->get('garante-email');
	   		$actividadLaboralGarante = $request->get('garante-laboral');
	   		$telLaboralGarante = $request->get('garante-telefono-trabajo');
	   		
	   		//fotocopias
	   		$garanteServicio = $files->get('garante-fotocopia-servicio');
	   		$garanteFotoDni = $files->get('garante-fotocopia-dni');
	    	$garanteRecibo = $files->get('garante-fotocopia-recibo');
	    	$garanteIngresos = $files->get('garante-fotocopia-ingresos');
	    	$garanteOtra1 = $files->get('garante-fotocopia-otra-1');
	    	$garanteOtra2 = $files->get('garante-fotocopia-otra-2');
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
		$credito->setProvinciaSolicitante();
		
    }	

     public function showSimuladorAction() {
		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'),));
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:Year');
		$years = $repository->findAll();
     	return $this->render(
        'KellsFrontBundle:Default:simulador.html.twig', array("form"=>$form->createView(), "years"=>$years));
     }
     
     public function simularCuotasAction(Request $request) {
     	
     	$logger = $this->get('logger');
     		
     	$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsBackBundle:AlarfinConfiguration');
		$configuration = $repository->findAll()[0];
		
		$yearId = $request->get('yearId');
		$year = $em->getRepository('KellsFrontBundle:Year')->find($yearId);
		$capital = (int)$request->get('capital');
		$y = (int)$year->getDescription();
		
		$logger->info('Año '.$y);
		$logger->info('Capital '.$capital);
		$intervalo0 = 2014;
		$intervalo1 = $intervalo0 - 6;
		$intervalo2 = $intervalo1 - 5;
		$intervalo3 = $intervalo2 - 5;
		$cuota2 = 0;
		$cuota4= 0;
		$cuota6= 0;
		$cuota8= 0;
		$cuota10= 0;
		$cuota12= 0;
		$cuota14 = 0;
		$cuota16 = 0;
		$cuota18 = 0;
		$cuota20 = 0;
		$cuota22 = 0;
		$cuota24 = 0;
		$cuota26 = 0;
		$cuota28 = 0;
		$cuota30 = 0;
		$cuota32 = 0;
		$cuota34 = 0;
		$cuota36 = 0;
		
		if ($y == $intervalo0) {
			$cuota2 = $capital * (float)$configuration->getCerokmCuotas2();
			$cuota4 = $capital * (float)$configuration->getCerokmCuotas4();
			$cuota6 = $capital * (float)$configuration->getCerokmCuotas6();
			$cuota8 = $capital * (float)$configuration->getCerokmCuotas8();
			$cuota10 = $capital * (float)$configuration->getCerokmCuotas10();
			$cuota12 = $capital * (float)$configuration->getCerokmCuotas12();
			$cuota14 = $capital * (float)$configuration->getCerokmCuotas14();
			$cuota16 = $capital * (float)$configuration->getCerokmCuotas16();
			$cuota18 = $capital * (float)$configuration->getCerokmCuotas18();
			$cuota20 = $capital * (float)$configuration->getCerokmCuotas20();
			$cuota22 = $capital * (float)$configuration->getCerokmCuotas22();
			$cuota24 = $capital * (float)$configuration->getCerokmCuotas24();
			$cuota26 = $capital * (float)$configuration->getCerokmCuotas26();
			$cuota28 = $capital * (float)$configuration->getCerokmCuotas28();
			$cuota30 = $capital * (float)$configuration->getCerokmCuotas30();
			$cuota32 = $capital * (float)$configuration->getCerokmCuotas32();
			$cuota34 = $capital * (float)$configuration->getCerokmCuotas34();
			$cuota36 = $capital * (float)$configuration->getCerokmCuotas36();
			
			
		} else if ($y < $intervalo0 && $y >= $intervalo1) {
			$logger->info('Intervalo: 2013-2008');
			$cuota2 = $capital * (float)$configuration->getUnoA5Cuotas2();
			$logger->info('Configuracion Cuota 1 a 5 '.$configuration->getUnoA5Cuotas2() );
			$logger->info('Valor Cuota 2 '.$cuota2 );
			$cuota4 = $capital * (float)$configuration->getUnoA5Cuotas4();
			$cuota6 = $capital * (float)$configuration->getUnoA5Cuotas6();
			$cuota8 = $capital * (float)$configuration->getUnoA5Cuotas8();
			$cuota10 = $capital * (float)$configuration->getUnoA5Cuotas10();
			$cuota12 = $capital * (float)$configuration->getUnoA5Cuotas12();
			$cuota14 = $capital * (float)$configuration->getUnoA5Cuotas14();
			$cuota16 = $capital * (float)$configuration->getUnoA5Cuotas16();
			$cuota18 = $capital * (float)$configuration->getUnoA5Cuotas18();
			$cuota20 = $capital * (float)$configuration->getUnoA5Cuotas20();
			$cuota22 = $capital * (float)$configuration->getUnoA5Cuotas22();
			$cuota24 = $capital * (float)$configuration->getUnoA5Cuotas24();
			$cuota26 = $capital * (float)$configuration->getUnoA5Cuotas26();
			$cuota28 = $capital * (float)$configuration->getUnoA5Cuotas28();
			$cuota30 = $capital * (float)$configuration->getUnoA5Cuotas30();
			$cuota32 = $capital * (float)$configuration->getUnoA5Cuotas32();
			$cuota34 = $capital * (float)$configuration->getUnoA5Cuotas34();
			$cuota36 = $capital * (float)$configuration->getUnoA5Cuotas36();
		} else if ($y < $intervalo1 && $y >= $intervalo2) {
			$cuota2 = $capital * (float)$configuration->getSeisA10Cuotas2();
			$cuota4 = $capital * (float)$configuration->getSeisA10Cuotas4();
			$cuota6 = $capital * (float)$configuration->getSeisA10Cuotas6();
			$cuota8 = $capital * (float)$configuration->getSeisA10Cuotas8();
			$cuota10 = $capital * (float)$configuration->getSeisA10Cuotas10();
			$cuota12 = $capital * (float)$configuration->getSeisA10Cuotas12();
			$cuota14 = $capital * (float)$configuration->getSeisA10Cuotas14();
			$cuota16 = $capital * (float)$configuration->getSeisA10Cuotas16();
			$cuota18 = $capital * (float)$configuration->getSeisA10Cuotas18();
			$cuota20 = $capital * (float)$configuration->getSeisA10Cuotas20();
			$cuota22 = $capital * (float)$configuration->getSeisA10Cuotas22();
			$cuota24 = $capital * (float)$configuration->getSeisA10Cuotas24();
			$cuota26 = $capital * (float)$configuration->getSeisA10Cuotas26();
			$cuota28 = $capital * (float)$configuration->getSeisA10Cuotas28();
			$cuota30 = $capital * (float)$configuration->getSeisA10Cuotas30();
			$cuota32 = $capital * (float)$configuration->getSeisA10Cuotas32();
			$cuota34 = $capital * (float)$configuration->getSeisA10Cuotas34();
			$cuota36 = $capital * (float)$configuration->getSeisA10Cuotas36();
		} else if ($y < $intervalo2 ) {
			$cuota2 = $capital * (float)$configuration->getOnceA15Cuotas2();
			$cuota4 = $capital * (float)$configuration->getOnceA15Cuotas4();
			$cuota6 = $capital * (float)$configuration->getOnceA15Cuotas6();
			$cuota8 = $capital * (float)$configuration->getOnceA15Cuotas8();
			$cuota10 = $capital * (float)$configuration->getOnceA15Cuotas10();
			$cuota12 = $capital * (float)$configuration->getOnceA15Cuotas12();
			$cuota14 = $capital * (float)$configuration->getOnceA15Cuotas14();
			$cuota16 = $capital * (float)$configuration->getOnceA15Cuotas16();
			$cuota18 = $capital * (float)$configuration->getOnceA15Cuotas18();
			$cuota20 = $capital * (float)$configuration->getOnceA15Cuotas20();
			$cuota22 = $capital * (float)$configuration->getOnceA15Cuotas22();
			$cuota24 = $capital * (float)$configuration->getOnceA15Cuotas24();
			$cuota26 = $capital * (float)$configuration->getOnceA15Cuotas26();
			$cuota28 = $capital * (float)$configuration->getOnceA15Cuotas28();
			$cuota30 = $capital * (float)$configuration->getOnceA15Cuotas30();
			$cuota32 = $capital * (float)$configuration->getOnceA15Cuotas32();
			$cuota34 = $capital * (float)$configuration->getOnceA15Cuotas34();
			$cuota36 = $capital * (float)$configuration->getOnceA15Cuotas36();
		}
		$logger->info('Valor Cuota 2 '.$cuota2 );
		$output = array();
		$output[] = array('key'=>'Cuota 2', 'value'=>$cuota2);
		$output[] = array('key'=>'Cuota 4', 'value'=>$cuota4);
		$output[] = array('key'=>'Cuota 6', 'value'=>$cuota6);
		$output[] = array('key'=>'Cuota 8', 'value'=>$cuota8);
		$output[] = array('key'=>'Cuota 10', 'value'=>$cuota10);
		$output[] = array('key'=>'Cuota 12', 'value'=>$cuota12);
		$output[] = array('key'=>'Cuota 14', 'value'=>$cuota14);
		$output[] = array('key'=>'Cuota 16', 'value'=>$cuota16);
		$output[] = array('key'=>'Cuota 18', 'value'=>$cuota18);
		$output[] = array('key'=>'Cuota 20', 'value'=>$cuota20);
		$output[] = array('key'=>'Cuota 22', 'value'=>$cuota22);
		$output[] = array('key'=>'Cuota 24', 'value'=>$cuota24);
		$output[] = array('key'=>'Cuota 26', 'value'=>$cuota26);
		$output[] = array('key'=>'Cuota 28', 'value'=>$cuota28);
		$output[] = array('key'=>'Cuota 30', 'value'=>$cuota30);
		$output[] = array('key'=>'Cuota 32', 'value'=>$cuota32);
		$output[] = array('key'=>'Cuota 34', 'value'=>$cuota34);
		$output[] = array('key'=>'Cuota 36', 'value'=>$cuota36);
		
		$response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($output));
        return $response;
     }
}
