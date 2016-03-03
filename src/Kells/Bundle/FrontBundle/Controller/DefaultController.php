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
use Kells\Bundle\FrontBundle\Form\Model\LicenseeRegistration;
use Kells\Bundle\FrontBundle\Entity\Car;
use Kells\Bundle\FrontBundle\Entity\Feature;
use Kells\Bundle\FrontBundle\Entity\ImageFile;
use Kells\Bundle\FrontBundle\Entity\CarImage;
use Kells\Bundle\FrontBundle\Entity\Fotocopias;
use Kells\Bundle\FrontBundle\Entity\FotocopiasConyuge;
use Kells\Bundle\FrontBundle\Entity\Credito;
use Kells\Bundle\FrontBundle\Entity\Model;

use Kells\Bundle\FrontBundle\Utils\Util;

class DefaultController extends Controller
{
	public function indexAction() {
		
		return $this->render('KellsFrontBundle:Default:index.html.twig');
	}
	
	public function concesionariasAction() {
		$repository = $this->getDoctrine()->getRepository('KellsFrontBundle:Licensee');
		$concesionarias =  $repository->findAll( );
		
		return $this->render('KellsFrontBundle:Default:concesionarias.html.twig', array( 'concesionarias' => $concesionarias));
	}
	
	public function publicacionesAction() {
		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'),));

		$repository = $this->getDoctrine()->getRepository('KellsFrontBundle:Car');

		$cars =  $repository->findBy(array('status'=>"PUBLISHED"), array('publishedDate' => 'DESC'));
		$trademarks = array();
		foreach ($cars as $car) {
			$trademark = $car->getTrademark();
			if(!array_key_exists ($trademark->getDescription(), $trademarks)) {
				$trademarks[$trademark->getDescription()] = 1;
			} else {
				$trademarks[$trademark->getDescription()] = $trademarks[$trademark->getDescription()] + 1;
			}
		}

		
		return $this->render('KellsFrontBundle:Default:publicaciones.html.twig', array( 'cars' => $cars, 'form' => $form->createView(),
        	'trademarksFilter'=> array(), 'pattern' => "", 'filter'=>false, 'model'=>"", 'totalCars'=> sizeof($cars) ));
	}

	public function allCarsAction() {
		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'),));

		$repository = $this->getDoctrine()->getRepository('KellsFrontBundle:Car');

		$cars =  $repository->findBy(array('status'=>"PUBLISHED"), array('publishedDate' => 'DESC'));
		$trademarks = array();
		$models = array();
		$directions = array();
		$fuels = array();
		

		
		foreach ($cars as $car) {
			//Filtro de marcas
			$trademark = $car->getTrademark();
			if(!array_key_exists ($trademark->getDescription(), $trademarks)) {
				$trademarks[$trademark->getDescription()] = 1;
			} else {
				$trademarks[$trademark->getDescription()] = $trademarks[$trademark->getDescription()] + 1;
			}
			
			//Filtro de modelos
			$model = $car->getModel();
			if(!array_key_exists ($model->getDescription(), $models)) {
				$models[$model->getDescription()] = 1;
			} else {
				$models[$model->getDescription()] = $models[$model->getDescription()] + 1;
			}
			
		//Filtro de combustibles
			$fuel = $car->getFuel();
			if(!array_key_exists ($fuel->getDescription(), $fuels)) {
				$fuels[$fuel->getDescription()] = 1;
			} else {
				$fuels[$fuel->getDescription()] = $fuels[$fuel->getDescription()] + 1;
			}
			
			//Filtro de direccion
			$direction = $car->getDirection();
			if ($direction)
				if(!array_key_exists ($direction->getDescription(), $directions)) {
					$directions[$direction->getDescription()] = 1;
				} else {
					$directions[$direction->getDescription()] = $directions[$direction->getDescription()] + 1;
				}
			
		}
		
		return $this->render('KellsFrontBundle:Default:publicaciones.html.twig', array( 'cars' => $cars, 'form' => $form->createView(),"pattern" => "",'filter'=>true,
			'marksKeysFilter' => array_keys($trademarks), 'trademarksFilter'=> $trademarks, 'markFilter' => "", 
        	'modelKeysFilter' => array_keys($models), 'modelsFilter'=> $models, 'modelFilter'=>"",
			'directionKeysFilter' => array_keys($directions), 'directionsFilter'=> $directions, 'directionFilter'=>"",
		    'fuelKeysFilter' => array_keys($fuels), 'fuelsFilter'=> $fuels, 'fuelFilter'=>"", 'minPriceFilter'=>"", "maxPriceFilter"=>""));
	}
	
	public function detailsAction( $carId ) {
		$repository = $this->getDoctrine()->getRepository('KellsFrontBundle:Car');

		$car =  $repository->find($carId);

		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'),));

		return $this->render('KellsFrontBundle:Default:ficha.html.twig', array( 'car' => $car , 'features' => $car->getFeatures(), 'form'=>$form->createView()));
	}

	public function searchCarAction(Request $request) {
		 
		$form = $this->createForm(new SearchType(), new Search());

		$form->handleRequest($request);

		$search = $form->getData();

		$pattern = $search->getPattern();
		$repository = $this->getDoctrine()->getRepository('KellsFrontBundle:Car');
		$query = $repository->createQueryBuilder('c')
		->leftJoin('c.model', 'm')
		->leftJoin('c.trademark', 't')
		->where('lower(m.description) LIKE lower(:pattern)')
		->orwhere('lower(t.description) LIKE lower(:pattern)')
		->orwhere('lower(c.title) LIKE lower(:pattern)')
		->andwhere('c.status = \'PUBLISHED\'')
		->setParameter('pattern', '%'.$pattern.'%')
		->getQuery();

		$cars =  $query->getResult();
		$trademarks = array();
		$models = array();
		$directions = array();
		$fuels = array();
		
		foreach ($cars as $car) {
			//Filtro de marcas
			$trademark = $car->getTrademark();
			if(!array_key_exists ($trademark->getDescription(), $trademarks)) {
				$trademarks[$trademark->getDescription()] = 1;
			} else {
				$trademarks[$trademark->getDescription()] = $trademarks[$trademark->getDescription()] + 1;
			}
			
			//Filtro de modelos
			$model = $car->getModel();
			if(!array_key_exists ($model->getDescription(), $models)) {
				$models[$model->getDescription()] = 1;
			} else {
				$models[$model->getDescription()] = $models[$model->getDescription()] + 1;
			}
			
		//Filtro de combustibles
			$fuel = $car->getFuel();
			if(!array_key_exists ($fuel->getDescription(), $fuels)) {
				$fuels[$fuel->getDescription()] = 1;
			} else {
				$fuels[$fuel->getDescription()] = $fuels[$fuel->getDescription()] + 1;
			}
			
			//Filtro de direccion
			$direction = $car->getDirection();
			if ($direction)
				if(!array_key_exists ($direction->getDescription(), $directions)) {
					$directions[$direction->getDescription()] = 1;
				} else {
					$directions[$direction->getDescription()] = $directions[$direction->getDescription()] + 1;
				}
			
		}
		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'),));
		
		return $this->render('KellsFrontBundle:Default:publicaciones.html.twig', array( 'cars' => $cars,
        	'form' => $form->createView(), "pattern" => $pattern,'filter'=>true,
			'marksKeysFilter' => array_keys($trademarks), 'trademarksFilter'=> $trademarks, 'markFilter' => "", 
        	'modelKeysFilter' => array_keys($models), 'modelsFilter'=> $models, 'modelFilter'=>"",
			'directionKeysFilter' => array_keys($directions), 'directionsFilter'=> $directions, 'directionFilter'=>"",
		    'fuelKeysFilter' => array_keys($fuels), 'fuelsFilter'=> $fuels, 'fuelFilter'=>"",'minPriceFilter'=>"", "maxPriceFilter"=>""
		));
	}

	public function filterResultsAction(Request $request) {
		 
		 
		$pattern = $request->get('pattern');
		$markFilter = $request->get('markFilter');
		$modelFilter = $request->get('modelFilter');
		$fuelFilter = $request->get("fuelFilter");
		$directionFilter = $request->get("directionFilter");
		$minPriceFilter = $request->get("minPrice");
		$maxPriceFilter = $request->get("maxPrice");
		
		
		$repository = $this->getDoctrine()->getRepository('KellsFrontBundle:Car');
		$queryBuilder = $repository->createQueryBuilder('c')
		->join('c.model', 'm')
		->join('c.trademark', 't')
		->join('c.fuel', 'f')
		->leftJoin('c.direction', 'd');
		if ($markFilter && $modelFilter){
			$queryBuilder->where('lower(t.description) LIKE lower(:trademark)');
			$queryBuilder->andwhere('lower(m.description) LIKE lower(:model)');
			$queryBuilder->setParameter('trademark', '%'.$this->getParameter($markFilter, $pattern).'%');
			$queryBuilder->setParameter('model', '%'.$this->getParameter($modelFilter, $pattern).'%');
		} else  if ($markFilter) {
			$queryBuilder->where('lower(t.description) LIKE lower(:trademark)');
			$queryBuilder->setParameter('trademark', '%'.$this->getParameter($markFilter, $pattern).'%');
		} else if ($modelFilter) {
		 	$queryBuilder->andwhere('lower(m.description) LIKE lower(:model)');
		 	$queryBuilder->setParameter('model', '%'.$this->getParameter($modelFilter, $pattern).'%');
		} else {
			$queryBuilder->where('lower(m.description) LIKE lower(:pattern)');
			$queryBuilder->orwhere('lower(t.description) LIKE lower(:pattern)');
			$queryBuilder->setParameter('pattern', '%'.$this->getParameter($markFilter, $pattern).'%');
		}
		if ($fuelFilter)
			$queryBuilder ->andwhere('lower(f.description) LIKE lower(:fuel)');
		if ($directionFilter) 
			$queryBuilder ->andwhere('d.description LIKE lower(:direction)');
		if ($minPriceFilter)
			$queryBuilder ->andwhere('c.price >=(:minPrice)');
		if ($maxPriceFilter)
			$queryBuilder ->andwhere('c.price <=(:maxPrice)');	
		
		$queryBuilder->andwhere('c.status = \'PUBLISHED\'');
		if ($fuelFilter)
			$queryBuilder->setParameter('fuel', $this->getParameter($fuelFilter, "%"));
		if ($directionFilter)
			$queryBuilder->setParameter('direction', $this->getParameter($directionFilter, "%"));
		if ($minPriceFilter)
			$queryBuilder->setParameter('minPrice', $this->getParameter($minPriceFilter));
		if ($maxPriceFilter)
			$queryBuilder->setParameter('maxPrice', $this->getParameter($maxPriceFilter));
		$query = $queryBuilder->getQuery();

		$cars = array();
		$carsWithoutFilter =  $query->getResult();
		
		$trademarks = array();
		
		
		if (!$markFilter) {
			
			foreach ($carsWithoutFilter as $car) {
				$trademark = $car->getTrademark();
				if(!array_key_exists ($trademark->getDescription(), $trademarks)) {
					$trademarks[$trademark->getDescription()] = 1;
				} else {
					$trademarks[$trademark->getDescription()] = $trademarks[$trademark->getDescription()] + 1;
				}
			}
		}
		
		$models= array();
		if (!$modelFilter) {
			foreach ($carsWithoutFilter as $car) {
				$model = $car->getModel();
				if(!array_key_exists ($model->getDescription(), $models)) {
					$models[$model->getDescription()] = 1;
				} else {
					$models[$model->getDescription()] = $models[$model->getDescription()] + 1;
				}
			}
		}
		
		$fuels = array();
		if (!$fuelFilter) {
			foreach ($carsWithoutFilter as $car) {
				
				$fuel = $car->getFuel();
				$description = $fuel->getDescription();
				if(!array_key_exists ($description, $fuels)) {
					$fuels[$description] = 1;
				} else {
					$fuels[$description] = $fuels[$description] + 1;
				}
			}
		}
		
		$directions = array();
		if (!$directionFilter) {
			foreach ($carsWithoutFilter as $car) {
				$direction = $car->getDirection();
				if ($direction) {
					$descripcion = $direction->getDescription();
					if(!array_key_exists ($descripcion, $directions)) {
						$directions[$descripcion] = 1;
					} else {
						$directions[$descripcion] = $directions[$descripcion] + 1;
					}
				}
			}
		}
		
		
		
		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'),));
		return $this->render('KellsFrontBundle:Default:publicaciones.html.twig', array( 'cars' => $carsWithoutFilter,
        	'form' => $form->createView(),'pattern' => $pattern, 'filter' => true,
			'marksKeysFilter' => array_keys($trademarks), 'trademarksFilter'=> $trademarks,  'markFilter' => $markFilter,  
			'modelKeysFilter' => array_keys($models), 'modelsFilter'=> $models, 'modelFilter'=> $modelFilter,
			'fuelKeysFilter' => array_keys($fuels), 'fuelsFilter'=> $fuels, 'fuelFilter'=>$fuelFilter, 
			'directionKeysFilter' => array_keys($directions), 'directionsFilter'=> $directions, 'directionFilter'=>$directionFilter, 
		'minPriceFilter'=>$minPriceFilter, "maxPriceFilter"=>$maxPriceFilter));
	}
	
	
	public function getParameter($parameter, $pattern) {
		if ($parameter) {
			return $parameter;
		}
		return $pattern;
	}
	
	public function removeFilterAction(Request $request) {
		
		$pattern = $request->get('pattern');
		$markFilter = $request->get('markFilter');
		$markShoulBeFilter = $request->get('markShoulBeFilter');
		
		$modelFilter = $request->get('modelFilter');
		$modelShouldBeFilter = $request->get('modelShoulBeFilter');
		
		$fuelFilter = $request->get('fuelFilter');
		$fuelShouldBeFilter = $request->get('fuelShoulBeFilter');
		
		$directionFilter = $request->get('directionFilter');
		$directionShouldBeFilter = $request->get('directionShoulBeFilter');
		
		$repository = $this->getDoctrine()->getRepository('KellsFrontBundle:Car');
		$queryBuilder = $repository->createQueryBuilder('c')
		->join('c.model', 'm')
		->join('c.trademark', 't')
		->join('c.fuel', 'f')
		->leftJoin('c.direction', 'd');
		if ($markFilter && $modelFilter){
			$queryBuilder->where('lower(t.description) LIKE lower(:trademark)');
			$queryBuilder->andwhere('lower(m.description) LIKE lower(:model)');
			$queryBuilder->setParameter('trademark', '%'.$this->getParameter($markFilter, $pattern).'%');
			$queryBuilder->setParameter('model', '%'.$this->getParameter($modelFilter, $pattern).'%');
		} else  if ($markFilter) {
			$queryBuilder->where('lower(t.description) LIKE lower(:trademark)');
			$queryBuilder->setParameter('trademark', '%'.$this->getParameter($markFilter, $pattern).'%');
		} else if ($modelFilter) {
		 	$queryBuilder->andwhere('lower(m.description) LIKE lower(:model)');
		 	$queryBuilder->setParameter('model', '%'.$this->getParameter($modelFilter, $pattern).'%');
		} else {
			$queryBuilder->where('lower(m.description) LIKE lower(:pattern)');
			$queryBuilder->orwhere('lower(t.description) LIKE lower(:pattern)');
			$queryBuilder->orwhere('lower(c.title) LIKE lower(:pattern)');
			$queryBuilder->setParameter('pattern', '%'.$this->getParameter($markFilter, $pattern).'%');
		}
		if ($fuelFilter)
			$queryBuilder ->andwhere('lower(f.description) LIKE lower(:fuel)');
		if ($directionFilter) 
			$queryBuilder ->andwhere('d.description LIKE lower(:direction)');
		
		$queryBuilder->andwhere('c.status = \'PUBLISHED\'');
		if ($fuelFilter)
			$queryBuilder->setParameter('fuel', $this->getParameter($fuelFilter, "%"));
		if ($directionFilter)
			$queryBuilder->setParameter('direction', $this->getParameter($directionFilter, "%"));
		$query = $queryBuilder->getQuery();
		

		$cars = array();
		$carsWithoutFilter =  $query->getResult();
		$trademarks = array();
		if ($markFilter && (!$markShoulBeFilter || $markShoulBeFilter == true) ) {
			for ($index = 0; $index < count($carsWithoutFilter); $index++){
				if ($carsWithoutFilter[$index]->getTrademark()->getDescription() != $markFilter){
					unset($carsWithoutFilter[$index]);
				}
			}
		} else {
			foreach ($carsWithoutFilter as $car) {
				$trademark = $car->getTrademark();
				if(!array_key_exists ($trademark->getDescription(), $trademarks)) {
					$trademarks[$trademark->getDescription()] = 1;
				} else {
					$trademarks[$trademark->getDescription()] = $trademarks[$trademark->getDescription()] + 1;
				}
			}
		}
		
		$carsWithoutFilter = array_values($carsWithoutFilter);
		
		$models= array();
		if ($modelFilter && !$modelShouldBeFilter) {
			$i=0;
			foreach ($carsWithoutFilter as $car) {
				if ($car->getModel()->getDescription() != $modelFilter){
					unset($carsWithoutFilter[$i]);
				}
				$i++;
			}
		} else {
			foreach ($carsWithoutFilter as $car) {
				$model = $car->getModel();
				if(!array_key_exists ($model->getDescription(), $models)) {
					$models[$model->getDescription()] = 1;
				} else {
					$models[$model->getDescription()] = $models[$model->getDescription()] + 1;
				}
			}
		}
		
		$carsWithoutFilter = array_values($carsWithoutFilter);
		$fuels= array();
		if ($fuelFilter && !$fuelShouldBeFilter) {
			$i=0;
			foreach ($carsWithoutFilter as $car) {
				if ($car->getfuel()->getDescription() != $fuelFilter){
					unset($carsWithoutFilter[$i]);
				}
				$i++;
			}
		} else {
			foreach ($carsWithoutFilter as $car) {
				$fuel = $car->getfuel();
				if(!array_key_exists ($fuel->getDescription(), $fuels)) {
					$fuels[$fuel->getDescription()] = 1;
				} else {
					$fuels[$fuel->getDescription()] = $fuels[$fuel->getDescription()] + 1;
				}
			}
		}
		
		$carsWithoutFilter = array_values($carsWithoutFilter);
		$directions= array();
		if ($directionFilter && !$directionShouldBeFilter) {
			$i=0;
			foreach ($carsWithoutFilter as $car) {
					if (!$car->getDirection() || $car->getDirection()->getDescription() != $directionFilter ){
						unset($carsWithoutFilter[$i]);
					}
				$i++;
			}
		} else {
			foreach ($carsWithoutFilter as $car) {
				$direction = $car->getDirection();
				if ($direction)
					if(!array_key_exists ($direction->getDescription(), $directions)) {
						$directions[$direction->getDescription()] = 1;
					} else {
						$directions[$direction->getDescription()] = $directions[$direction->getDescription()] + 1;
					}
			}
		}
		
		
		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'),));
		return $this->render('KellsFrontBundle:Default:publicaciones.html.twig', array( 'cars' => $carsWithoutFilter,
        	'form' => $form->createView(),  'pattern' => $pattern,
        	'marksKeysFilter' => array_keys($trademarks), 'trademarksFilter'=> $trademarks, 'markFilter' => $markFilter, 
        	'modelsFilter' => $models,  'modelFilter' => $modelFilter,'modelKeysFilter' => array_keys($models),
        	'fuelsFilter' => $fuels,  'fuelFilter' => $fuelFilter,'fuelKeysFilter' => array_keys($fuels),
			'directionsFilter' => $directions,  'directionFilter' => $directionFilter,'directionKeysFilter' => array_keys($directions),
        	'filter' => true ));
		
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

			$url = $this->generateUrl('user_confirm', array('token' => $user->getToken()), true);
			$message = \Swift_Message::newInstance()
			->setSubject('Confirmación de registración a Alarfin')
			->setFrom('no-responder@alarfin.com.ar')
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

	public function userRegisterConfirmAction(Request $request, $token) {
		
		if ($token) {
			$em = $this->getDoctrine()->getManager();
			$repository = $em->getRepository('KellsFrontBundle:User');
			$user = $repository->findOneByToken($token);
			if ($user) {
				//delete token and change status
				$user->setToken('');
				$user->setStatus(true);
				$em->flush();

			$request->getSession()->getFlashBag()->add(
            'notice',
            'Gracias por la confirmación, ya se encuentra registrado en Alarfin'
        	);
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

			$url =   $url = $this->generateUrl('licensee_confirm', array('token' => $licensee->getToken()), true);
			$message = \Swift_Message::newInstance()
			->setSubject('Confirmación de registración a Alarfin')
			->setFrom('no-responder@alarfin.com.ar')
			->setTo($licensee->getMail())
			->setBody('<p>Gracias por registrarse</p>'.
        	'<p>Para terminar con el registro por favor haga click en el siguiente vínculo </p>'.
        	'<p><a href="'.$url.'">Confirmar</a></p>', 'text/html'
            	
        	);
        	$this->get('mailer')->send($message);
        		
        	return $this->redirect($this->generateUrl('user_message_confirm'));
		}

		return $this->render(
        'KellsFrontBundle:Default:licenseeRegistration.html.twig',
		array('form' => $form->createView())
		);
	}

	public function licenseeRegisterConfirmAction(Request $request, $token) {
		if ($token) {
			$em = $this->getDoctrine()->getManager();
			$repository = $em->getRepository('KellsFrontBundle:Licensee');
			$licensee = $repository->findOneByToken($token);
			if ($licensee) {
				//delete token and change status
				$licensee->setToken('');
				$licensee->setStatus(true);
				$em->flush();

				
        $request->getSession()->getFlashBag()->add(
            'notice',
            'Gracias por la confirmación, ya se encuentra registrado en Alarfin'
        );
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
			'tipo' => $request->get('tipo'),
		));
	}
	

	public function userMyPublicationsAction() {
		$user = $this->get('security.context')->getToken()->getUser();

		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'),));
		return $this->render(
        'KellsFrontBundle:Default:misPublicaciones.html.twig', array("form"=>$form->createView(), "myCars" => $user->getCars()));

	}

	public function toPublishAction($message = null) {
		$em = $this->getDoctrine()->getManager();
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

		$user = $this->get('security.context')->getToken()->getUser();
		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'), ));
		return $this->render(
        'KellsFrontBundle:Default:publicar.html.twig', array("message" => $message, "form"=>$form->createView(), 'trademarks'=> $trademarks, 'fuels'=>$fuels, 'years'=>$years, 
        	'directions'=>$directions, 'transmissions'=>$transmissions, 'car' => null));

	}

	public function publishAction(Request $request) {
		$user = $this->getUser();
		 
		$carId = $request->get('carId');
		 
		$title = $request->get('titulo');
		$description = $request->get('descripcion');
		$price = $request->get('precio');

		$errorMsg = "Marca  Modelo son obligatoyrios";
		$trademarkId = $request->get('marca');
		$modelId = $request->get('modelo');
		$modeloNuevo = $request->get('modeloNuevo');
		 
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
		if ($user->getRoles()[0] == 'ROLE_USER') {
			$car->setUser($user);
		} else {
			$car->setLicensee($user);
		}
		$car->setColor($color);
		 
		if ($mandatoryImageFile) {
			$car->setMandatoryImage($mandatoryImage);
		}
		if ($imageFile1){
			$car->setImage1($image1);
		}
		if ($imageFile2) {
			$car->setImage2($image2);
		}
		if ($imageFile3) {
			$car->setImage3($image3);
		}
		if ($imageFile4) {
			$car->setImage4($image4);
		}
		if ($imageFile5) {
			$car->setImage5($image5);
		}
		if ($imageFile6) {
			$car->setImage6($image6);
		}


		$repository = $em->getRepository('KellsFrontBundle:Fuel');
		$fuel = $repository->find($fuelId);
		$car->setFuel($fuel);

		$repository = $em->getRepository('KellsFrontBundle:Trademark');
		$trademark = $repository->find($trademarkId);
		$car->setTrademark($trademark);

		$repository = $em->getRepository('KellsFrontBundle:Model');
		if (!$modelId && $modeloNuevo ) {
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
	
		$userDescription = '';
		if ($user->getRoles()[0] == 'ROLE_USER') {
			$userDescription = $user->getFirstName(). ' '.$user->getLastName();
		} else {
			$userDescription = $user->getFantasyName();
		}
		
		$url = $this->generateUrl('details', array('carId' => $car->getId()), true);
	    $repository = $em->getRepository('KellsBackBundle:AlarfinConfiguration');
		$configuration = $repository->findAll()[0];
		
		$message1 = \Swift_Message::newInstance()
		->setSubject('Nueva publicación: '.$userDescription.' / '.$car->getTitle())
		->setFrom('no-responder@alarfin.com.ar')
		->setTo($configuration->getEmail1())
		->setBody("<p>Para acceder a la nueva publicacion, por favor, haga click en: ".$url."</p>", 'text/html');

		
		$this->get('mailer')->send($message1);
		
		
		if ($configuration->getEmail2()) {
			$message1 = \Swift_Message::newInstance()
			->setSubject('Nueva publicación: '.$userDescription.' / '.$car->getTitle())
		->setFrom('no-responder@alarfin.com.ar')
		->setTo($configuration->getEmail2())
		->setBody("<p>Para acceder a la nueva publicacion, por favor, haga click en: ".$url."</p>", 'text/html');
			
			$this->get('mailer')->send($message1);
		}
		
		if ($configuration->getEmail3()) {
			$message1 = \Swift_Message::newInstance()
			->setSubject('Nueva publicación: '.$userDescription.' / '.$car->getTitle())
		->setFrom('no-responder@alarfin.com.ar')
		->setTo($configuration->getEmail3())
		->setBody("<p>Para acceder a la nueva publicacion, por favor, haga click en: ".$url."</p>", 'text/html');

			$this->get('mailer')->send($message1);
		}
		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'),));

		return $this->redirect($this->generateUrl('user_myPublications'));
	}

	 
	public function getModelsAction(Request $request) {

		$id = $request->get('id');
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:Trademark');
		$trademark = $repository->find($id);
		$output = array();
		foreach  ($trademark->getModels() as $model) {
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
		$id = $request->get('id');
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:Province');
		$province = $repository->find($id);
		$output = array();
		foreach  ($province->getCities() as $city) {
			$output[] = array(
              'id' => $city->getId(),
              'description' => $city->getDescription(),
			);
		}

		$response = new Response();
		$response->headers->set('Content-Type', 'application/json');
		$response->setContent(json_encode( $output));
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

	public function toFinalizeAction(Request $request) {
		$id = $request->get('id');
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:Car');
		$car = $repository->find($id);
		$car->setStatus("FINALIZED");
		$em->flush();
		return $this->redirect($this->generateUrl('user_myPublications'));
	}

	public function toEditAction(Request $request) {
		$id = $request->get('id');
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:Car');
		$car = $repository->find($id);
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

		$user = $this->get('security.context')->getToken()->getUser();
		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'), ));
		return $this->render(
        'KellsFrontBundle:Default:publicar.html.twig', array("form"=>$form->createView(), 'trademarks'=> $trademarks, 'fuels'=>$fuels, 'years'=>$years, 
        	'directions'=>$directions, 'transmissions'=>$transmissions, 'car'=>$car));

	}

	public function republishAction(Request $request) {
		$id = $request->get('id');
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:Car');
		$car = $repository->find($id);
		$car->setStatus("PUBLISHED");
		$em->flush();
		return $this->redirect($this->generateUrl('user_myPublications'));
	}

	public function showCreditRequestAction($message = null) {

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
			
		return $this->render(
        'KellsFrontBundle:Default:solicitar-credito-usuario.html.twig', array("form"=>$form->createView(), "userRole"=>$user->getRoles()[0], 'trademarks'=> $trademarks, 'provinces'=>$provinces, 'fuels'=>$fuels, 'years'=>$years, 
        	'directions'=>$directions, 'transmissions'=>$transmissions, 'message'=>$message));

	}

	public function showCreditRequestSuccessAction() {
		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'),));

		return $this->render(
        'KellsFrontBundle:Default:solicitar-credito-success.html.twig', array("form"=>$form->createView() ));
	}

	public function creditAction(Request $request) {
		$user = $this->getUser();
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
	  
		if ($user->getRoles()[0] == 'ROLE_LICENSEE') {
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
				$fotocopiaOtra2Garante = $this->createFotocopia($garanteOtra2);
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
		$credito->setUser($this->getUser()->getName());

		$credito->setTasa($this->getUser()->getName());
		$credito->setTea($this->getUser()->getName());

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
		
		return $this->redirect($this->generateUrl('creditRequestSuccess', array("message"=>"Se ha enviado la solicitud exitosamente")));

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

		 
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsBackBundle:AlarfinConfiguration');
		$configuration = $repository->findAll()[0];

		$yearId = $request->get('yearId');
		$year = $em->getRepository('KellsFrontBundle:Year')->find($yearId);
		$capital = (int)$request->get('capital');
		if ($configuration->getImpuestos()) {
			$capital = $capital + (int)$configuration->getImpuestos();
		}
		$y = (int)$year->getDescription();

		$intervalo0 = $configuration->getAnio0km();
		$intervalo1 = $intervalo0 - 5;
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
			$cuota2 = $capital * (float)$configuration->getUnoA5Cuotas2();
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
				
		}
		$output = array();
		$output[] = array('key'=>'2 Cuotas', 'value'=>round($cuota2));
		$output[] = array('key'=>'4 Cuotas', 'value'=>round($cuota4));
		$output[] = array('key'=>'6 Cuotas', 'value'=>round($cuota6));
		$output[] = array('key'=>'8 Cuotas', 'value'=>round($cuota8));
		$output[] = array('key'=>'10 Cuotas', 'value'=>round($cuota10));
		$output[] = array('key'=>'12 Cuotas', 'value'=>round($cuota12));
		$output[] = array('key'=>'14 Cuotas', 'value'=>round($cuota14));
		$output[] = array('key'=>'16 Cuotas', 'value'=>round($cuota16));
		$output[] = array('key'=>'18 Cuotas', 'value'=>round($cuota18));
		$output[] = array('key'=>'20 Cuotas', 'value'=>round($cuota20));
		$output[] = array('key'=>'22 Cuotas', 'value'=>round($cuota22));
		$output[] = array('key'=>'24 Cuotas', 'value'=>round($cuota24));
		if ($y >= $intervalo2 ) {
			$output[] = array('key'=>'26 Cuotas', 'value'=>round($cuota26));
			$output[] = array('key'=>'28 Cuotas', 'value'=>round($cuota28));
			$output[] = array('key'=>'30 Cuotas', 'value'=>round($cuota30));
			$output[] = array('key'=>'32 Cuotas', 'value'=>round($cuota32));
			$output[] = array('key'=>'34 Cuotas', 'value'=>round($cuota34));
			$output[] = array('key'=>'36 Cuotas', 'value'=>round($cuota36));
		}
		$response = new Response();
		$response->headers->set('Content-Type', 'application/json');
		$response->setContent(json_encode($output));
		return $response;
	}
	 
	public function getValorCuotasAction(Request $request) {
		//calculo valor cuota
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsBackBundle:AlarfinConfiguration');
		$configuration = $repository->findAll()[0];

		$cantidadCuotas = $request->get('cuotas');
		$montoCredito = $request->get('monto');
		if ($configuration->getImpuestos()) {
			$montoCredito = (int)$montoCredito + (int)$configuration->getImpuestos();
		}
		$yearId = $request->get('yearId');
		$repository = $em->getRepository('KellsFrontBundle:Year');
		$year = $repository->find($yearId);

		$intervalo0 = $configuration->getAnio0km();

		$intervalo1 = $intervalo0 - 5;
		$intervalo2 = $intervalo1 - 5;
		$intervalo3 = $intervalo2 - 5;
		$y = (int) $year->getDescription();
		$cuota=0;
		if ($y == $intervalo0) {
			if ($cantidadCuotas == 2) {
				$cuota = (int)$montoCredito * (float)$configuration->getCerokmCuotas2();
			} else if ($cantidadCuotas == 4) {
				$cuota = (int)$montoCredito * (float)$configuration->getCerokmCuotas4();
			} else if ($cantidadCuotas == 6) {
				$cuota = (int)$montoCredito * (float)$configuration->getCerokmCuotas6();
			} else if ($cantidadCuotas == 8) {
				$cuota = (int)$montoCredito * (float)$configuration->getCerokmCuotas8();
			} else if ($cantidadCuotas == 10) {
				$cuota = (int)$montoCredito * (float)$configuration->getCerokmCuotas10();
			} else if ($cantidadCuotas == 12) {
				$cuota = (int)$montoCredito * (float)$configuration->getCerokmCuotas12();
			} else if ($cantidadCuotas == 14) {
				$cuota = (int)$montoCredito * (float)$configuration->getCerokmCuotas14();
			} else if ($cantidadCuotas == 16) {
				$cuota = (int)$montoCredito * (float)$configuration->getCerokmCuotas16();
			} else if ($cantidadCuotas == 18) {
				$cuota = (int)$montoCredito * (float)$configuration->getCerokmCuotas18();
			} else if ($cantidadCuotas == 20) {
				$cuota = (int)$montoCredito * (float)$configuration->getCerokmCuotas20();
			} else if ($cantidadCuotas == 22) {
				$cuota = (int)$montoCredito * (float)$configuration->getCerokmCuotas22();
			} else if ($cantidadCuotas == 24) {
				$cuota = (int)$montoCredito * (float)$configuration->getCerokmCuotas24();
			} else if ($cantidadCuotas == 26) {
				$cuota = (int)$montoCredito * (float)$configuration->getCerokmCuotas26();
			} else if ($cantidadCuotas == 28) {
				$cuota = (int)$montoCredito * (float)$configuration->getCerokmCuotas28();
			} else if ($cantidadCuotas == 30) {
				$cuota = (int)$montoCredito * (float)$configuration->getCerokmCuotas30();
			} else if ($cantidadCuotas == 32) {
				$cuota = (int)$montoCredito * (float)$configuration->getCerokmCuotas32();
			} else if ($cantidadCuotas == 34) {
				$cuota = (int)$montoCredito * (float)$configuration->getCerokmCuotas34();
			} else if ($cantidadCuotas == 36) {
				$cuota = (int)$montoCredito * (float)$configuration->getCerokmCuotas36();
			}
		} else if ($y < $intervalo0 && $y >= $intervalo1) {
			if ($cantidadCuotas == 2) {
				$cuota = (int)$montoCredito * (float)$configuration->getUnoA5Cuotas2();
			} else if ($cantidadCuotas == 4) {
				$cuota = (int)$montoCredito * (float)$configuration->getUnoA5Cuotas4();
			} else if ($cantidadCuotas == 6) {
				$cuota = (int)$montoCredito * (float)$configuration->getUnoA5Cuotas6();
			} else if ($cantidadCuotas == 8) {
				$cuota = (int)$montoCredito * (float)$configuration->getUnoA5Cuotas8();
			} else if ($cantidadCuotas == 10) {
				$cuota = (int)$montoCredito * (float)$configuration->getUnoA5Cuotas10();
			} else if ($cantidadCuotas == 12) {
				$cuota = (int)$montoCredito * (float)$configuration->getUnoA5Cuotas12();
			} else if ($cantidadCuotas == 14) {
				$cuota = (int)$montoCredito * (float)$configuration->getUnoA5Cuotas14();
			} else if ($cantidadCuotas == 16) {
				$cuota = (int)$montoCredito * (float)$configuration->getUnoA5Cuotas16();
			} else if ($cantidadCuotas == 18) {
				$cuota = (int)$montoCredito * (float)$configuration->getUnoA5Cuotas18();
			} else if ($cantidadCuotas == 20) {
				$cuota = (int)$montoCredito * (float)$configuration->getUnoA5Cuotas20();
			} else if ($cantidadCuotas == 22) {
				$cuota = (int)$montoCredito * (float)$configuration->getUnoA5Cuotas22();
			} else if ($cantidadCuotas == 24) {
				$cuota = (int)$montoCredito * (float)$configuration->getUnoA5Cuotas24();
			} else if ($cantidadCuotas == 26) {
				$cuota = (int)$montoCredito * (float)$configuration->getUnoA5Cuotas26();
			} else if ($cantidadCuotas == 28) {
				$cuota = (int)$montoCredito * (float)$configuration->getUnoA5Cuotas28();
			} else if ($cantidadCuotas == 30) {
				$cuota = (int)$montoCredito * (float)$configuration->getUnoA5Cuotas30();
			} else if ($cantidadCuotas == 32) {
				$cuota = (int)$montoCredito * (float)$configuration->getUnoA5Cuotas32();
			} else if ($cantidadCuotas == 34) {
				$cuota = (int)$montoCredito * (float)$configuration->getUnoA5Cuotas34();
			} else if ($cantidadCuotas == 36) {
				$cuota = (int)$montoCredito * (float)$configuration->getUnoA5Cuotas36();
			}
		} else if ($y < $intervalo1 && $y >= $intervalo2) {
			if ($cantidadCuotas == 2) {
				$cuota = (int)$montoCredito * (float)$configuration->getSeisA10Cuotas2();
			} else if ($cantidadCuotas == 4) {
				$cuota = (int)$montoCredito * (float)$configuration->getSeisA10Cuotas4();
			} else if ($cantidadCuotas == 6) {
				$cuota = (int)$montoCredito * (float)$configuration->getSeisA10Cuotas6();
			} else if ($cantidadCuotas == 8) {
				$cuota = (int)$montoCredito * (float)$configuration->getSeisA10Cuotas8();
			} else if ($cantidadCuotas == 10) {
				$cuota = (int)$montoCredito * (float)$configuration->getSeisA10Cuotas10();
			} else if ($cantidadCuotas == 12) {
				$cuota = (int)$montoCredito * (float)$configuration->getSeisA10Cuotas12();
			} else if ($cantidadCuotas == 14) {
				$cuota = (int)$montoCredito * (float)$configuration->getSeisA10Cuotas14();
			} else if ($cantidadCuotas == 16) {
				$cuota = (int)$montoCredito * (float)$configuration->getSeisA10Cuotas16();
			} else if ($cantidadCuotas == 18) {
				$cuota = (int)$montoCredito * (float)$configuration->getSeisA10Cuotas18();
			} else if ($cantidadCuotas == 20) {
				$cuota = (int)$montoCredito * (float)$configuration->getSeisA10Cuotas20();
			} else if ($cantidadCuotas == 22) {
				$cuota = (int)$montoCredito * (float)$configuration->getSeisA10Cuotas22();
			} else if ($cantidadCuotas == 24) {
				$cuota = (int)$montoCredito * (float)$configuration->getSeisA10Cuotas24();
			} else if ($cantidadCuotas == 26) {
				$cuota = (int)$montoCredito * (float)$configuration->getSeisA10Cuotas26();
			} else if ($cantidadCuotas == 28) {
				$cuota = (int)$montoCredito * (float)$configuration->getSeisA10Cuotas28();
			} else if ($cantidadCuotas == 30) {
				$cuota = (int)$montoCredito * (float)$configuration->getSeisA10Cuotas30();
			} else if ($cantidadCuotas == 32) {
				$cuota = (int)$montoCredito * (float)$configuration->getSeisA10Cuotas32();
			} else if ($cantidadCuotas == 34) {
				$cuota = (int)$montoCredito * (float)$configuration->getSeisA10Cuotas34();
			} else if ($cantidadCuotas == 36) {
				$cuota = (int)$montoCredito * (float)$configuration->getSeisA10Cuotas36();
			}
		} else if($y < $intervalo2 ) {
			if ($cantidadCuotas == 2) {
				$cuota = (int)$montoCredito * (float)$configuration->getOnceA15Cuotas2();
			} else if ($cantidadCuotas == 4) {
				$cuota = (int)$montoCredito * (float)$configuration->getOnceA15Cuotas4();
			} else if ($cantidadCuotas == 6) {
				$cuota = (int)$montoCredito * (float)$configuration->getOnceA15Cuotas6();
			} else if ($cantidadCuotas == 8) {
				$cuota = (int)$montoCredito * (float)$configuration->getOnceA15Cuotas8();
			} else if ($cantidadCuotas == 10) {
				$cuota = (int)$montoCredito * (float)$configuration->getOnceA15Cuotas10();
			} else if ($cantidadCuotas == 12) {
				$cuota = (int)$montoCredito * (float)$configuration->getOnceA15Cuotas12();
			} else if ($cantidadCuotas == 14) {
				$cuota = (int)$montoCredito * (float)$configuration->getOnceA15Cuotas14();
			} else if ($cantidadCuotas == 16) {
				$cuota = (int)$montoCredito * (float)$configuration->getOnceA15Cuotas16();
			} else if ($cantidadCuotas == 18) {
				$cuota = (int)$montoCredito * (float)$configuration->getOnceA15Cuotas18();
			} else if ($cantidadCuotas == 20) {
				$cuota = (int)$montoCredito * (float)$configuration->getOnceA15Cuotas20();
			} else if ($cantidadCuotas == 22) {
				$cuota = (int)$montoCredito * (float)$configuration->getOnceA15Cuotas22();
			} else if ($cantidadCuotas == 24) {
				$cuota = (int)$montoCredito * (float)$configuration->getOnceA15Cuotas24();
			}
		}
		 
		$output = round($cuota);
		$response = new Response();
		$response->headers->set('Content-Type', 'application/json');
		$response->setContent(json_encode($output));
		return $response;
	}
	 
	public function recuperarUserAction() {
		return $this->render('KellsFrontBundle:Default:recuperar-mi-contrasena.html.twig', array('error'=>""));
	}
	 
	public function recuperarUserContrasenaAction(Request $request) {
		$mail = $request->get('email');
		$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository('KellsFrontBundle:User')->findOneByMail($mail);
		if (!$user) {
			$user = $em->getRepository('KellsFrontBundle:Licensee')->findOneByMail($mail);
			if (!$user) {
				$request->getSession()->getFlashBag()->add(
            'notice',
            'El E-mail no se encuentra registrado'
        );
				return $this->render('KellsFrontBundle:Default:recuperar-mi-contrasena.html.twig', array('error'=>"Yes!"));
			}
		}
		$message = \Swift_Message::newInstance()
		->setSubject('Alarfin recuperación contraseña')
		->setFrom('no-responder@alarfin.com.ar')
		->setTo($user->getMail())
		->setBody('<p>Su contraseña es:'.$user->getPassword().'</p>', 'text/html'
		);
		$this->get('mailer')->send($message);
		return $this->render('KellsFrontBundle:Default:recuperar-mi-contrasena-ok.html.twig', array('error'=>"Yes!"));
	}
	 
	public function enviarConsultaAction(request $request) {

		$consulta = $request->get('consulta');
		$publicacionId = $request->get('id');
		$em = $this->getDoctrine()->getManager();
		$car = $em->getRepository('KellsFrontBundle:Car')->find($publicacionId);
		$user = $car->getUser();
		if (!$user) {
			$user = $car->getLicensee();
		}
		$userThatMakeARequest = $this->getUser();
		$name = "";
		if ($userThatMakeARequest->getRoles()[0] == 'ROLE_LICENSEE') {
			$name = $userThatMakeARequest->getFantasyName();
		} else {
			$name= $userThatMakeARequest->getFirstName();
		}
		
		$url = $this->generateUrl('details', array('id' =>$publicacionId ), true);
		$message = \Swift_Message::newInstance()
		->setSubject('Realizaron una consulta por la publicación '.$car->getTitle())
		->setFrom('no-responder@alarfin.com.ar')
		->setTo($user->getMail())
		->setBody("<p>".$consulta."</p><p>Nombre: ".$name."</p><p>E-mail: : ".$userThatMakeARequest->getMail()."</p><p>Publicación: ".$url."</p>", 'text/html');

		$this->get('mailer')->send($message);

		$repository = $em->getRepository('KellsBackBundle:AlarfinConfiguration');
		$configuration = $repository->findAll()[0];
		
		$message1 = \Swift_Message::newInstance()
		->setSubject('Realizaron una consulta por la publicación '.$car->getTitle())
		->setFrom('no-responder@alarfin.com.ar')
		->setTo($configuration->getEmail1())
		->setBody("<p>".$consulta."</p><p>Nombre: ".$name."</p><p>E-mail: : ".$userThatMakeARequest->getMail()."</p><p>Publicación: ".$url."</p>", 'text/html');

		$this->get('mailer')->send($message1);
		 // store a message for the very next request
   		$this->get('session')->getFlashBag()->add('notice', 'Su consulta fue enviada exitosamente!');
		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'),));

		if ($configuration->getEmail2()) {
			$message1 = \Swift_Message::newInstance()
			->setSubject('Realizaron una consulta por la publicación '.$car->getTitle())
			->setFrom('no-responder@alarfin.com.ar')
			->setTo($configuration->getEmail2())
			->setBody("<p>".$consulta."</p><p>Nombre: ".$name."</p><p>E-mail: : ".$userThatMakeARequest->getMail()."</p><p>Publicación: ".$url."</p>", 'text/html');

		$this->get('mailer')->send($message1);
		}
		if ($configuration->getEmail3()) {
			$message1 = \Swift_Message::newInstance()
			->setSubject('Realizaron una consulta por la publicación '.$car->getTitle())
			->setFrom('no-responder@alarfin.com.ar')
			->setTo($configuration->getEmail3())
			->setBody("<p>".$consulta."</p><p>Nombre: ".$name."</p><p>E-mail: : ".$userThatMakeARequest->getMail()."</p><p>Publicación: ".$url."</p>", 'text/html');

		$this->get('mailer')->send($message1);
		}
		return $this->render('KellsFrontBundle:Default:ficha.html.twig', array( 'car' => $car , 'features' => $car->getFeatures(), 'form'=>$form->createView()));
	}
	
	public function registerNowAction() {
		return $this->render('KellsFrontBundle:Default:registrarmeAhora.html.twig');
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
    
    public function contactoEnviarAction(Request $request) {
    	
    	$body= '
					<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
					<html>
					<head>
					<title>Untitled Document</title>
					<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
					</head>
					<body>
						<table width="560" border="0" style="font-family:Arial, Tahoma, Verdana, Helvetica, sans-serif;font-size:12px;color:#000;">
						  <tr>
							<td width="210">Nombre y Apellido:</td>
							<td width="350"><strong>'.$request->get("nombre").'</strong></td>
						  </tr>
						  <tr>
							<td>E-mail:</td>
							<td><strong>'.$request->get("email").'</strong></td>
						  </tr>
						  <tr>
							<td>Teléfono:</td>
							<td><strong>'.$request->get("telefono").'</strong></td>
						  </tr>
						  <tr>
							<td>Consulta o comentario:</td>
							<td><strong>'.$request->get("consulta").'</strong></td>
						  </tr>
						</table>
					</body>
					</html>			
					';
    	
    	$message1 = \Swift_Message::newInstance()
			->setSubject('Contacto desde la web')
			->setFrom('info@alarfin.com.ar')
			->setTo("alarfinsa@gmail.com")
			->setBody($body, 'text/html');

		$this->get('mailer')->send($message1);
    	
    	return $this->render('KellsFrontBundle:Default:contacto-gracias.html.twig');
    }
    
    public function overcomePublicationsAction() {
    	$em = $this->getDoctrine()->getManager();
	    $repository = $em->getRepository('KellsFrontBundle:Car');
		$cars =  $repository->findBy(array('status'=>"PUBLISHED"), array('publishedDate' => 'DESC'));
		$carsFinalized= array();
		$diferencias = array();
		foreach ($cars as $car) {
			$now = new \DateTime();
			$diff = $now->diff($car->getPublishedDate());
				$diferencias[] = $diff;
			if ($diff >= 90) {
				$userType;
				$userId;
				$carsFinalized[] =  $car;
				if ($car->getUser()) {
					$userType = "U";
					$userId = $car->getUser()->getId();
				} else {
					$userType = "L";
					$userId = $car->getLicensee()->getId();
				}
				$url = $this->generateUrl('publicaciones_usuario', array('userId' =>$userId, 'userType' => $userType), true);
				$body= '
					<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
					<html>
					<head>
					<title>Untitled Document</title>
					<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
					</head>
					<body>
						<p>La publicación: '.$car->getTitle().' ha vencido.</p>
						<p>Puede republicar desde la sección Mis Publicaciones Finalizadas: '.$url.' </p>
					</body>
					</html>			
					';
				//$car->setStatus("FINALIZED");
				//if ($car->getUser()) {
					//$message1 = \Swift_Message::newInstance()
						//->setSubject('Contacto desde la web')
						//->setFrom('no-responder@alarfin.com.ar')
						//->setTo($car->getUser()->getMail())
						//->setBody($body, 'text/html');

					//$this->get('mailer')->send($message1);
				//} elseif ($car->getLicensee()){
					//$message1 = \Swift_Message::newInstance()
						//->setSubject('Contacto desde la web')
						//->setFrom('no-responder@alarfin.com.ar')
						//->setTo($car->getLicensee()->getMail())
						//->setBody($body, 'text/html');

					//$this->get('mailer')->send($message1);
				//}
				//$em->flush();
				
			}
		}
			return $this->render('KellsFrontBundle:Default:overcomePublications.html.twig', array('cars'=>$carsFinalized, 'diferencias'=>$diferencias));
    
    }
}

