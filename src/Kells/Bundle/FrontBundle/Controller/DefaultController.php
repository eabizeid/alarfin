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

use Kells\Bundle\FrontBundle\Utils\Util;

class DefaultController extends Controller
{
    public function indexAction() {
    	$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'),));

    	$repository = $this->getDoctrine()->getRepository('KellsFrontBundle:Car');

		$cars =  $repository->findAll();
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
     	$registration = new Registration();
		$form = $this->createForm(new RegistrationType(), $registration, array('action' => $this->generateUrl('licensee_create'),));


     	return $this->render('KellsFrontBundle:Default:licenseeRegistration.html.twig', array('form' => $form->createView()));
     }
     
	public function licenseeConfirmAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm(new RegistrationType(), new Registration());

		$form->handleRequest($request);

		if ($form->isValid()) {
			$registration = $form->getData();

			$licensee = $registration->getLicensee(); 
			$licensee->setStatus(false);
			$licensee->setToken(Util::getToken());
			$em->persist($licensee);
			$em->flush();

			$url = 'http://'.$_SERVER['SERVER_NAME'].':8000/app_dev.php/licensee/register/confirm/'.$licensee->getToken();
			$message = \Swift_Message::newInstance()
        	->setSubject('Confirmar su registracion')
        	->setFrom('eduardo.abizeid@gmail.com')
        	->setTo($licensee->getMail())
        	->setBody('<p>Gracias por registrarse</p>'.
        	'<p>Para terminar con el registro por favor haga click en el siguiente vínculo </p>'.
        	'<p><a href="'.$url.'">Confirmar</a></p>', 'text/html'
            	
        	);
    		$this->get('mailer')->send($message);
			
			return $this->redirect($this->generateUrl('licensee_message_confirm'));
		}

		return $this->render(
        'KellsFrontBundle:Default:licenseeRegistration.html.twig',
		array('form' => $form->createView())
		);
	}
	
	public function licenseeRegisterConfirmAction($token) {
		if ($token) {
			$em = $this->getDoctrine()->getManager();
			$repository = $em->getRepository('KellsFrontBundle:Licensee');
			$licensee = $repository->findOneByToken($token);
			if ($licensee) {
				//delete token and change status
				$licensee->setToken('');
				$licensee->setStatus(true);
				$em->flush();
				
				return $this->redirect($this->generateUrl('kells_front_homepage'));
			}
		}
			return $this->redirect($this->generateUrl('licenseeRegistration'));
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
        	'directions'=>$directions, 'transmissions'=>$transmissions));
		
	}
	
    public function publishAction(Request $request) {
	   	$logger = $this->get('logger');
   		$user = $this->getUser();
    	
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
		$logger->info('mandatoryImage: '.$mandatoryImageFile->getClientOriginalName());
		$logger->info('mandatoryImage extension: '.$mandatoryImageFile->guessExtension());
   		
		$mandatoryImage = new ImageFile();
		$mandatoryImage->setFile($mandatoryImageFile);
		
		$image1 = $this->createImage($imageFile1);
		$image2 = $this->createImage($imageFile2);
		$image3 = $this->createImage($imageFile3);
		$image4 = $this->createImage($imageFile4);
		$image5 = $this->createImage($imageFile5);
		$image6 = $this->createImage($imageFile6);
	
		
		$em = $this->getDoctrine()->getManager();
		
		$car = new Car();
		$car->setTitle($title);		
   		$car->setDescription($description);
   		$car->setPrice($price);
   		$car->setKm($kms);
   		$car->setUser($user);
   		$car->setColor($color);
		$car->setMandatoryImage($mandatoryImage);
		if ($image1)
			$car->addImage($image1);
		if ($image2)
			$car->addImage($image2);
		if ($image3)
			$car->addImage($image3);
		if ($image4)
			$car->addImage($image4);
		if ($image5)
			$car->addImage($image5);
		if ($image6)
			$car->addImage($image6);	
		
		
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
		
		
		
		//CONFORT
		$aireAcondicionado = $request->get('AIRACON');
		if($aireAcondicionado) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('AIRACON');
			$car->addFeature($feature);	
		}
		
    	$alarmaLuces = $request->get('ALARMLUC');
		if($alarmaLuces) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('ALARMLUC');
			$car->addFeature($feature);	
		}

    	$aperturaBaul = $request->get('APERBAUL');
		if($aperturaBaul) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('APERBAUL');
			$car->addFeature($feature);	
		}
		$asientosElectricos = $request->get('ASIENELEC');
		if($asientosElectricos) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('ASIENELEC');
			$car->addFeature($feature);	
		}
		
    	$asientoReg = $request->get('ASREGULA');
		if($asientoReg) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('ASREGULA');
			$car->addFeature($feature);	
		}
		
		
    	$asientoTRebat = $request->get('ASREBAT');
		if($asientoTRebat) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('ASREBAT');
			$car->addFeature($feature);	
		}
    	
		$cierreCen = $request->get('BLQCNTDOOR');
		if($cierreCen) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('BLQCNTDOOR');
			$car->addFeature($feature);	
		}
		
    	$climatizador = $request->get('CLIMAUT');
		if($climatizador) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('CLIMAUT');
			$car->addFeature($feature);	
		}
		
    	$computadora = $request->get('COMPABO');
		if($computadora) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('COMPABO');
			$car->addFeature($feature);	
		}
     	
		$velo = $request->get('CTRLVEL');
		if($velo) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('CTRLVEL');
			$car->addFeature($feature);	
		}
		
		$espeelec = $request->get('ESPELEC');
		if($espeelec) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('ESPELEC');
			$car->addFeature($feature);	
		}
    	
		$sensEsta = $request->get('ESTACIONAM');
		if($sensEsta) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('ESTACIONAM');
			$car->addFeature($feature);	
		}
		
    	$faros = $request->get('FAROREG');
		if($faros) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('FAROREG');
			$car->addFeature($feature);	
		}
    	
		$gps = $request->get('GPS');
		if($gps) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('GPS');
			$car->addFeature($feature);	
		}	

		$sensorLluvia = $request->get('SENSLL');
		if($sensorLluvia) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('SENSLL');
			$car->addFeature($feature);	
		}
    	$sensorLuz = $request->get('SENSLUZ');
		if($sensorLuz) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('SENSLUZ');
			$car->addFeature($feature);	
		}
    	
		$cuero = $request->get('TAPCUERO');
		if($cuero) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('TAPCUERO');
			$car->addFeature($feature);	
		}
    	$techo = $request->get('TECHOCORR');
		if($techo) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('TECHOCORR');
			$car->addFeature($feature);	
		}
    	
		$cristales = $request->get('VIDELEC');
		if($cristales) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('VIDELEC');
			$car->addFeature($feature);	
		}		
		
		//Seguridad
		$stop = $request->get('3LUZSTOP');
		if($stop) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('3LUZSTOP');
			$car->addFeature($feature);
		}	
                                          
        $abs = $request->get('ABS');
		if($abs) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('ABS');
			$car->addFeature($feature);
		}	
        $airbag = $request->get('AIR1');
		if($airbag) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('AIR1');
			$car->addFeature($feature);
		}	
        
		$airbagP = $request->get('AIR2');
		if($airbagP) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('AIR2');
			$car->addFeature($feature);
		}	
        
        $airbagLat = $request->get('AIR3');
		if($airbagLat) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('AIR3');
			$car->addFeature($feature);
		}	
        
        $airbagCort = $request->get('AIRBAGCORT');
		if($airbagCort) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('AIRBAGCORT');
			$car->addFeature($feature);
		}	
        
        $alarma = $request->get('ALAR');
		if($alarma) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('ALAR');
			$car->addFeature($feature);
		}	
        
        $apoyaCab = $request->get('APCABEZA');
		if($apoyaCab) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('APCABEZA');
			$car->addFeature($feature);
		}	
        
        $blind = $request->get('BLIND');
		if($blind) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('BLIND');
			$car->addFeature($feature);
		}	
        
        $ctrlTrac = $request->get('CNTTRACC');
		if($ctrlTrac) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('CNTTRACC');
			$car->addFeature($feature);
		}	
        
        $estab = $request->get('CONTR');
		if($estab) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('CONTR');
			$car->addFeature($feature);
		}	
        
        $dblCtrl = $request->get('DOBTRACC');
		if($dblCtrl) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('DOBTRACC');
			$car->addFeature($feature);
		}	
        
        $antineblas = $request->get('FARANTI');
		if($antineblas) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('FARANTI');
			$car->addFeature($feature);
		}	
        
        $xenon = $request->get('FAROXEN');
		if($xenon) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('FAROXEN');
			$car->addFeature($feature);
		}	
        
        $inmvMotor = $request->get('INMOVMOT');
		if($inmvMotor) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('INMOVMOT');
			$car->addFeature($feature);
		}	
        
        $isofix = $request->get('ISOFIX');
		if($isofix) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('ISOFIX');
			$car->addFeature($feature);
		}	
        
        $antiTras = $request->get('NEBLTRAS');
		if($antiTras) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('NEBLTRAS');
			$car->addFeature($feature);
		}	
        
        $ffrenado = $request->get('REPFUERZA');
		if($ffrenado) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('REPFUERZA');
			$car->addFeature($feature);
		}	
        
		//<h5><strong>Sonido</strong></h5>
		$cd = $request->get('CAJACD');
		if($cd) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('CAJACD');
			$car->addFeature($feature);
		}        
		
		$radio = $request->get('AM/FM');
		if($radio) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('AM/FM');
			$car->addFeature($feature);
		}
    	$bluetooth = $request->get('BLUETOOTH');
		if($bluetooth) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('BLUETOOTH');
			$car->addFeature($feature);
		}
		
    	$cargadorCd = $request->get('CARGADORCD');
		if($cargadorCd) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('CARGADORCD');
			$car->addFeature($feature);
		}
		
    	$caset = $request->get('CASET');
		if($caset) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('CASET');
			$car->addFeature($feature);
		}
		
    	$comandoSat = $request->get('COMANDOSAT');
		if($comandoSat) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('COMANDOSAT');
			$car->addFeature($feature);
		}
		
    	$dvd = $request->get('DVD');
		if($dvd) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('DVD');
			$car->addFeature($feature);
		}
		
    	$entAux = $request->get('ENTAUXILIA');
		if($entAux) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('ENTAUXILIA');
			$car->addFeature($feature);
		}
		
    	$mp3 = $request->get('MP3');
		if($mp3) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('MP3');
			$car->addFeature($feature);
		}
		
    	$repCd = $request->get('REPRODCD');
		if($repCd) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('REPRODCD');
			$car->addFeature($feature);
		}
		
    	$tarjetaSD = $request->get('TARJETASD');
		if($tarjetaSD) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('TARJETASD');
			$car->addFeature($feature);
		}
		
    	$usb = $request->get('USB');
		if($usb) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('USB');
			$car->addFeature($feature);
		}                                   

		//<h5><strong>Exterior</strong></h5>
    	$limpialav = $request->get('LIMPIA/LAV');
		if($limpialav) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('LIMPIA/LAV');
			$car->addFeature($feature);
		}
		
    	$llantasAli = $request->get('LLANALEAC');
		if($llantasAli) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('LLANALEAC');
			$car->addFeature($feature);
		}

		$paragPintados = $request->get('PARAGOLPES');
		if($paragPintados) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('PARAGOLPES');
			$car->addFeature($feature);
		}
		
    	$vidPol = $request->get('VIDPOLARIZ');
		if($vidPol) {
			$repository = $em->getRepository('KellsFrontBundle:Feature');
			$feature = $repository->find('VIDPOLARIZ');
			$car->addFeature($feature);
		}
       
		$car->setPublishedDate(new \DateTime());
		
		$em->persist($car);
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
}
