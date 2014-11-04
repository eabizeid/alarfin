<?php
namespace  Kells\Bundle\FrontBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LicenseeType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('cuit', 'text');
        $builder->add('socialReason', 'text');
        $builder->add('fantasyName', 'text');
        $builder->add('telephone', 'text');
        $builder->add('mail', 'email');
        $builder->add('plainPassword', 'repeated', array(
           'first_name'  => 'password',
           'second_name' => 'confirm',
           'type'        => 'password',
           'required' => true,
    	   'first_options'  => array('label' => 'Contraseña '),
    	   'second_options' => array('label' => 'Repetir contraseña '),
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Kells\Bundle\FrontBundle\Entity\Licensee'
        ));
    }

    public function getName()
    {
        return 'Licensee';
    }
}