<?php
// src/Kells/LicenseeBundle/Form/Type/RegistrationType.php
namespace Kells\Bundle\FrontBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
	private $em;
	
  	public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('licensee', new LicenseeType($em));
        $builder->add(
            'terms',
            'checkbox',
            array('property_path' => 'termsAccepted')
        );
        $builder->add('register', 'submit', array ('attr' => array('class' => 'btn btn-form btn-lg', 'name'=>'btn_enviar'),));
    }

    public function getName()
    {
        return 'registration';
    }
}