<?php
namespace  Kells\Bundle\FrontBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('firstName', 'text');
		$builder->add('lastName', 'text');
        $builder->add('telephone', 'text');
        $builder->add('mail', 'email');
        $builder->add('password', 'repeated', array(
           'first_name'  => 'password',
           'second_name' => 'confirm',
           'type'        => 'password',
        	'invalid_message' => 'Las contraseñas deben coincidir',
           'required' => true,
    	   'first_options'  => array('label' => 'Contraseña '),
    	   'second_options' => array('label' => 'Repetir contraseña '),
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Kells\Bundle\FrontBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'User';
    }
}