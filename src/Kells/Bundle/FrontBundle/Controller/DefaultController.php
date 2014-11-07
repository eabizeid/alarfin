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

			$url = 'http://'.$_SERVER['SERVER_NAME'].'/app_dev.php/user/register/confirm/'.$user->getToken();
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
		
		
		$user = $this->get('security.context')->getToken()->getUser();
		
		$searchForm = new Search();
		$form = $this->createForm(new SearchType(), $searchForm, array('action' => $this->generateUrl('searchCar'), ));
		return $this->render(
        'KellsFrontBundle:Default:publicar.html.twig', array("form"=>$form->createView(), 'trademarks'=> $trademarks));
		
	}
	
   
	public function getModelsAction(Request $request) {
		  $logger = $this->get('logger');
		$id = $request->get('id');
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('KellsFrontBundle:Trademark');
		$trademark = $repository->find($id);
		$logger->info('trademark: '.$trademark->getId().' ');$logger->info('models: ');
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
}
