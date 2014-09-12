<?php

namespace Kells\LicenseeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Kells\LicenseeBundle\Form\Type\RegistrationType;
use Kells\LicenseeBundle\Form\Model\Registration;

use Kells\LicenseeBundle\Form\Type\LoginType;
use Kells\LicenseeBundle\Form\Model\Login;

class LicenseeController extends Controller {

	public function signInAction() {
		$login = new Login();
		$form = $this->createForm(new LoginType(), $login, array('action' => $this->generateUrl('licensee_login'),));

		return $this->render(
            'KellsLicenseeBundle:Licensee:login.html.twig', array('form' => $form->createView()));
	}
	
	public function loginAction(Request $request) {
		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm(new LoginType(), new Login());

		$form->handleRequest($request);
 		$logger = $this->get('logger');
		if ($form->isValid()) {
			$login = $form->getData();
			$repository = $em->getRepository('KellsLicenseeBundle:Licensee');
			$licensee = $repository->findOneBy(
				array('cuit' => $login->getCuit(), 'plainPassword' => $login->getPassword(), 'status'=>true)
			);
			
			if ($licensee) {
				return $this->render(
            		'KellsFrontBundle:Default:index.html.twig');
			}
		}
		
		return $this->render(
            'KellsLicenseeBundle:Licensee:login.html.twig', array('form' => $form->createView()));
		
	}
	
	public function registerAction() {
		$registration = new Registration();
		$form = $this->createForm(new RegistrationType(), $registration, array('action' => $this->generateUrl('licensee_create'),));

		return $this->render(
            'KellsLicenseeBundle:Licensee:register.html.twig',
		array('form' => $form->createView())
		);
	}


	public function createAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm(new RegistrationType(), new Registration());

		$form->handleRequest($request);

		if ($form->isValid()) {
			$registration = $form->getData();

			$licensee = $registration->getLicensee(); 
			$licensee->setStatus(false);
			$licensee->setToken($this->getToken());
			$em->persist($licensee);
			$em->flush();

			$url = 'http://'.$_SERVER['SERVER_NAME'].'/app_dev.php/licensee/register/confirm/'.$licensee->getToken();
			$message = \Swift_Message::newInstance()
        	->setSubject('Confirmar su registracion')
        	->setFrom('eduardo.abizeid@gmail.com')
        	->setTo($licensee->getMail())
        	->setBody('<p>Gracias por registrarse</p>'.
        	'<p>Para terminar con el registro por favor haga click en el siguiente vínculo </p>'.
        	'<p><a href="'.$url.'">Confirmar</a></p>', 'text/html'
            	
        	);
    		$this->get('mailer')->send($message);
			
			return $this->redirect($this->generateUrl('licensee_register'));
		}

		return $this->render(
        'KellsLicenseeBundle:Licensee:register.html.twig',
		array('form' => $form->createView())
		);
	}
	
	public function confirmAction($token) {
		if ($token) {
			$em = $this->getDoctrine()->getManager();
			$repository = $em->getRepository('KellsLicenseeBundle:Licensee');
			$licensee = $repository->findOneByToken($token);
			if ($licensee) {
				//delete token and change status
				$licensee->setToken('');
				$licensee->setStatus(true);
				$em->flush();
				return $this->render(
            		'KellsFrontBundle:Default:index.html.twig'
		);
			}
		}
			return $this->redirect($this->generateUrl('licensee_register'));
	}
	
	
	private  function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 0) return $min; // not so random...
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
	}

	private function getToken($length=32){
	    $token = "";
	    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
	    $codeAlphabet.= "0123456789";
	    for($i=0;$i<$length;$i++){
	        $token .= $codeAlphabet[$this->crypto_rand_secure(0,strlen($codeAlphabet))];
	    }
	    return $token;
	}
}